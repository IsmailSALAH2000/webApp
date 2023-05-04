<?php

require_once '/app/model/forum.php';
require_once '/app/model/User.php';
require_once 'ForumDataStructures.php.php';
require_once '/app/controllers/Users/Sessions.php';
require_once '/app/controllers/ViewLauncher.php';

/*
    Au chargement de la page, on va appeler les fonctions demandées dans la variable POST 'whatToDo', qui représentent des endpoints pour cette page. C'est-à-dire que peu importe le résultat de ces fonctions, une vue sera chargée à leur issue.

    Utilisation : passer les paramètres en POST.
    'whatToDo' correspond à :
        - 'addTopic' pour créer un topic. Paramètres supplémentaires obligatoires :
            - 'creatorLogin', correspond au login du créateur (string) (peut être obtenue via la classe Session).
            - 'title', correspond au titre du topic (string).
            - 'firstMessageContent', correspond au contenu du premier message (string).
        - 'addMessage' pour créer un message. Paramètres supplémentaires obligatoires :
            - 'message', correspond à une instance de la classe Message. L'attribut "id" sera ignoré.
            - 'creatorLogin', correspond au login du créateur (string) (peut être obtenu via la classe Session).
        - 'removeTopic' pour supprimer un topic. Paramètres supplémentaires obligatoires :
            - 'id', correspond à l'id du topic à supprimer (int).
        - 'removeMessage' pour supprimer un message. Paramètres supplémentaires obligatoires :
            - 'idMessage', correspond à l'id du message à supprimer (int).
            - 'idTopic', correspond à l'id du topic auquel le message appartient (int) (permet de rediriger l'utilisateur sur la page du topic après la suppression).
*/

if(isset($_POST['whatToDo']))
{
    switch($_POST['whatToDo'])
    {
        case 'addTopic':
            if(!isset($_POST['creatorLogin']) || !isset($_POST['title']) || !isset($_POST['firstMessageContent']))
                throw new Exception('Impossible d\'ajouter un topic : un ou plusieurs paramètre(s) POST inexistant(s).');
            ForumController::AddTopic($_POST['creatorLogin'], $_POST['title'], $_POST['firstMessageContent']);
            break;
        case 'addMessage':
            if(!isset($_POST['message']) || !isset($_POST['creatorLogin']))
                throw new Exception('Impossible d\'ajouter un message : un ou plusieurs paramètre(s) POST inexistant(s).');
            ForumController::AddMessage($_POST['message'], $_POST['creatorLogin']);
            break;
        case 'removeTopic':
            if(!isset($_POST['id']))
                throw new Exception('Impossible de suppriemr un topic : paramètre POST "id" inexistant.');
            ForumController::RemoveTopic($_POST['id']);
            break;
        case 'removeMessage':
            if(!isset($_POST['idMessage']) || !isset($_POST['idTopic']))
                throw new Exception('Impossible de supprimer un message : un ou plusieurs paramètre(s) POST inexistant(s).');
            ForumController::RemoveMessage($_POST['idMessage'], $_POST['idTopic']);
            break;
        default:
            break;
    }
}

class ForumController
{
    /**
     * Retourne tous les en-têtes de topic du forum.
     *
     * @return array Un tableau d'instances de TopicHeader.
     */
    public static function GetAllTopicHeaders() : array
    {
        Forum: $forumInstance = new Forum();
        $rawTopics = $forumInstance->getAllTopics();

        $topicHeaders = array();

        User: $userInstance = new User();

        foreach($rawTopics as $rawTopic) // Pour chaque topic brut du modèle
        {
            $topicHeader = new TopicHeader();

            $topicHeader->id = $rawTopic['idTopic'];
            $topicHeader->title = $rawTopic['titre'];
            $rawUser = $userInstance->getUtilisateur($rawTopic['idUtilisateur']);
            $topicHeader->creator = $rawUser['prenom'] . ' ' . $rawUser['nom'];
            $topicHeader->answersNumber = $rawTopic['nbReponses'];

            array_push($topicHeaders, $topicHeader);
        }

        return $topicHeaders;
    }

    /**
     * Retourne un topic complet à partir de son id. Il contiendra donc son en-tête et la liste de tous ses messages.
     *
     * @param integer $id L'id du topic.
     * @return Topic|null Le topic complet, ou null si l'id est introuvable.
     */
    public static function GetFullTopic(int $id) : ?Topic
    {
        Forum: $forumInstance = new Forum();

        $rawTopic = $forumInstance->getTopic($id);
        if(empty($rawTopic)) return null;

        User: $userInstance = new User();

        Topic: $topic = new Topic();

        $topic->header->id = $rawTopic['idTopic'];
        $topic->header->title = $rawTopic['titre'];
        $topic->header->creator = $userInstance->getUtilisateur($rawTopic['idUtilisateur']);
        $topic->header->answersNumber = $rawTopic['nbReponses'];

        $rawMessages = $forumInstance->getAllMessages($rawTopic['idTopic']);
        if(empty($rawMessages)) return $topic;

        foreach($rawMessages as $rawMessage)
        {
            Message: $message = new Message();

            $message->id = $rawMessage['idMessage'];
            $message->idTopic = $id;
            $rawUser = $userInstance->getUtilisateur($rawMessage['idUtilisateur']);
            $message->author = $rawUser['prenom'] . ' ' . $rawUser['nom'];
            $message->date = $rawMessage['dateMessage'];
            $message->content = $rawMessage['contenu'];

            array_push($topic->messages, $message);
        }

        return $topic;
    }

    /**
     * Ajoute un topic au forum, puis redirige l'utilisateur vers la vue affichant le topic créé.
     * Usage interne uniquement, utiliser des variables POST pour ajouter un topic.
     *
     * @param string $creatorLogin Le login du créateur.
     * @param string $title Le premier message du créateur du topic.
     * @return void
     */
    public static function AddTopic(string $creatorLogin, string $title, string $firstMessageContent) : void
    {
        Forum: $forumInstance = new Forum();

        int: $idTopic = $forumInstance->ajoutTopic($title, $creatorLogin, $firstMessageContent);

        ViewLauncher::TopicCreated($idTopic);
    }

    /**
     * Ajoute un message à un topic, puis redirige l'utilisateur sur la vue du topic en question.
     * Usage interne uniquement, utiliser des variables POST pour ajouter un message.
     *
     * @param Message $message Le message à ajouter. L'attribut "id" sera ignoré ici.
     * @param string $creatorLogin Le login du créateur.
     * @return void
     */
    public static function AddMessage(Message $message, string $creatorLogin) : void
    {
        Forum: $forumInstance = new Forum();

        $forumInstance->ajoutMessage($message->idTopic, $creatorLogin, $message->content);

        ViewLauncher::MessageCreated($message->idTopic);
    }

    /**
     * Supprime un topic du forum.
     * Usage interne uniquement, utiliser des variables POST pour supprime un topic.
     *
     * @param integer $id L'id du topic à supprimer.
     * @return void
     */
    public static function RemoveTopic(int $id) : void
    {
        if(!Session::Exists() || !Session::IsAdmin()) return;

        Forum: $forumInstance = new Forum();

        $forumInstance->supprimeTopic($id);

        ViewLauncher::TopicRemoved();
    }

    /**
     * Supprime un message d'un topic.
     * Usage interne uniquement, utiliser des variables POST pour supprimer un message.
     *
     * @param integer $idMessage L'id du message à supprimer.
     * @param integer $idTopic L'id du topic pour rediriger l'utilisateur sur la page qui contenait le message supprimé.
     * @return void
     */
    public static function RemoveMessage(int $idMessage, int $idTopic) : void
    {
        if(!Session::Exists() || !Session::IsAdmin()) return;

        Forum: $forumInstance = new Forum();

        $forumInstance->supprimeMessage($idMessage);

        ViewLauncher::MessageRemoved($idTopic);
    }
}

?>