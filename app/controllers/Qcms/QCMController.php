<?php

require_once '/app/model/QcmModel.php'
require_once 'QCM.php'
require_once '/app/controllers/ViewsLauncher.php'

/*
    Au chargement de la page, on va appeler les fonctions demandées dans la variable POST 'whatToDo', qui représentent des endpoints pour cette page. C'est-à-dire que peu importe le résultat de ces fonctions, une vue sera chargée à leur issue.

    Utilisation : passer les paramètres en POST.
    'whatToDo' correspond à :
        - 'addQCM' pour ajouter un QCM. Paramètres supplémentaires obligatoires :
            - 'qcm', correspond à une instance de la classe QCM.
        - 'removeQCM' pour supprimer un QCM. Paramètres supplémentaires obligatoires :
            - 'qcmID', correspond à l'id (~ nom) du QCM à supprimer (string).
*/

if(isset($_POST['whatToDo']))
{
    switch($_POST['whatToDo'])
    {
        case 'addQCM':
            if(!isset($_POST['qcm']))
                throw new Exception('Impossible d\'ajouter un QCM : paramètre POST "qcm" inexistant.');
            QCMController::AddQCM($_POST['qcm']);
            break;
        case 'removeQCM':
            if(!isset($_POST['qcmId']))
                throw new Exception('Impossible de supprimer un QCM : paramètre POST "qcmId" inexistant.');
            QCMController::RemoveQCMById($_POST['qcmId']);
            break;
        default:
            break;
    }
}

class QCMController
{
    /*
        Renvoie un tableau d'instances de QCMHeader. Ce tableau contient tous les id (~ noms) et type de tous les qcm stockés sur le site.
    */
    public static function GetAllQCMHeaders()
    {
        $qcmModelInstance = new QcmModel();
        $allQCMIds = $qcmModelInstance->getAllQCM();
        $out = array();

        foreach($allQCMIds as $qcmId) // Pour chaque ID de qcm
        {
            $qcm = new QCMHeader();
            $qcm->id = $qcmId;
            $qcm->type = $qcmModelInstance->getTypeQCM($qcmId);

            if($qcm->type == null) continue; // Si on ne trouve pas le type du qcm, on ne l'ajoute pas à la liste.

            array_push($out, $qcm);
        }

        return $out;
    }
    
    /*
        Retourne une QCM selon son ID. Retourne null en cas d'id introuvable.
    */
    public static function QetQCMById($id)
    {
        $qcmModelInstance = new QcmModel();
        $rawQCM = $qcmModelInstance->getQCM($id); // Récupération du QCM depuis le modèle sous forme brute.

        if($rawQCM == null) return null;

        $qcm = new QCM(); // On crée une instance de la classe QCM, permettant une manipulation plus aisée de l'information.
        $qcm->header->id = $id;
        $qcm->header->type = $rawQCM['type'];

        foreach($rawQCM['questions'] as $rawQuestion) // Pour chaque question du QCM brut
        {
            $question = new Question(); // On crée une instance de la classe Question.
            $question->label = $rawQuestion['text'];

            foreach($rawQuestion['choices'] as $rawChoice) // Pour chaque proposition du QCM brut
            {
                $answer = new Answer(); // On crée une instance de la classe Answer (proposition)
                $answer->label = $rawChoice['text'];
                $answer->isCorrect = ($rawChoice['correct'] == 'true' ? true : false);

                array_push($question->answers, $answer);
            }

            array_push($qcm->questions, $question);
        }

        return $qcm;
    }

    /*
        Permet de savoir si un id (~ nom) de QCM est disponible ou non.
        Retourn true s'il est disponible, faux sinon.
    */
    public static function IsQCMIdAvailable($id)
    {
        $qcmModelInstance = new QcmModel();
        if ($qcmModelInstance->QCMExiste($id) == 1) return false;
        else return true;
    }

    /*
        Ajoute un qcm sur le serveur.
    */
    public static function AddQCM($qcm)
    {
        $qcmModelInstance = new QcmModel();
        $dataToSend = array();
        $dataToSend['type'] = $qcm->header->type;
        $dataToSend['questions'] = array();

        foreach($qcm->questions as $question) // Pour chaque question du QCM
        {
            $rawQuestion = array(); // On crée un tableau contenant l'énoncé de la question et les réponses.
            $rawQuestion['text'] = $question->label;
            $rawQuestion['choices'] = array();

            foreach($question->answers as $answer) // Pour chaque proposition du QCM
            {
                $rawChoice = array(); // On crée un tableau contenant l'énoncé de la proposition et si elle est correcte ou non.
                $rawChoice['text'] = $answer->label;
                $rawChoice['correct'] = ($answer->isCorrect ? 'true' : '');

                array_push($rawQuestions['choices'], $rawChoice);
            }

            array_push($dataToSend['questions'], $rawQuestion);
        }

        $qcmModelInstance->ajoutQCM($qcm->header->id, $dataToSend);

        ViewsLauncher::QCMAdded();
    }

    /*
        Supprime un QCM du serveur selon son id (~ nom);
    */
    public static function RemoveQCMById($id)
    {
        $qcmModelInstance = new QcmModel();
        $qcmModelInstance->supprimeQCM($id);

        ViewsLauncher::QCMRemoved();
    }
}

?>