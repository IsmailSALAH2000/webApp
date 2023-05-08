<?php

enum RegisterErrorReason
{
    case LoginAlreadyUsed;
    case PasswordNotStrongEnough;
    case MailAlreadyUsed;
    case UnknownError;
}

class ViewLauncher
{
    /*
        Pour ouvrir une vue.
    */
    public static function OpenView($name)
    {
        header('location:/webApp/app/vues/pages/' . $name);
    }

    /*
        Erreur 404.
    */
    public static function Error404()
    {
        ViewLauncher::OpenView('Error404.php');
    }

    /*
        Quand l'utilisateur se trompe de nom d'utilisateur/mot de passe.
    */
    public static function BadLogin()
    {
        ViewLauncher::OpenView('connexion/connexion.php');
    }

    /*
        Quand l'utilisateur s'est conencté avec succès.
    */
    public static function LoggedIn()
    {
        ViewLauncher::OpenView('accueil/accueil.php');
    }

    /*
        Quand l'utilisateur s'est déconnecté.
    */
    public static function LoggedOut()
    {
        ViewLauncher::OpenView('accueil/accueil.php');
    }

    /*
        Quand l'inscription n'est pas possible.
    */
    public static function BadRegister(RegisterErrorReason $reason)
    {
        ViewLauncher::OpenView('inscription/inscription.php');
    }

    /*
        Quand l'inscription s'est déroulée avec succès.
    */
    public static function Registered()
    {
        ViewLauncher::OpenView('accueil/accueil.php');
    }

    /*
        Quand un QCM a été ajouté sur le serveur.
    */
    public static function QCMAdded()
    {
        ViewLauncher::OpenView('qcm/qcm.php');
    }

    /*
        Quand un QCM a été supprimé du serveur.
    */
    public static function QCMRemoved()
    {
        ViewLauncher::OpenView('qcm/qcm.php');
    }

    /*
        Quand un cours a été ajouté avec succès.
    */
    public static function LessonAdded()
    {
        ViewLauncher::OpenView('cours/listeCours.php');
    }

    /*
        Quand un cours a été ajouté avec succès.
    */
    public static function LessonAddedError($error)
    {
        ViewLauncher::OpenView('cours/ajoutCours.php?error='.$error);
    }

    /*
        Quand un cours a été supprimé avec succès.
    */
    public static function LessonRemoved()
    {
        ViewLauncher::OpenView('cours/listeCours.php');
    }
    
    /**
     * Ouvre la vue du topic après sa création.
     *
     * @param integer $id L'id du topic créé.
     * @return void
     */
    public static function TopicCreated(int $id)
    {
        ViewLauncher::OpenView('forum/topicView.php?id=' . $id);
    }
    
    /**
     * Ouvre la vue du topic après la création d'un message.
     *
     * @param integer $idTopic L'id du topic du message créé.
     * @return void
     */
    public static function MessageCreated(int $idTopic)
    {
        ViewLauncher::OpenView('forum/topicview.php?id=' . $idTopic);
    }

    /*
        Quand un topic a été supprimé.
    */
    public static function TopicRemoved()
    {
        ViewLauncher::OpenView('forum/forum.php');
    }

    /**
     * Ouvre la vue adéquate après la suppression d'un message. On précise l'id du topic en question afin de rester sur la page du topic d'où provenait le message supprimé.
     *
     * @param integer $idTopic L'id du topic dont le message a été supprimé.
     * @return void
     */
    public static function MessageRemoved(int $idTopic)
    {
        ViewLauncher::OpenView('forum/topicview.php?id=' . $idTopic);
    }
}

?>
