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
        header('location:/app/view/' . $name);
    }

    /*
        Erreur 404.
    */
    public static function Error404()
    {
        OpenView('Error404.php');
    }

    /*
        Quand l'utilisateur se trompe de nom d'utilisateur/mot de passe.
    */
    public static function BadLogin()
    {
        OpenView('connexion.php');
    }

    /*
        Quand l'utilisateur s'est conencté avec succès.
    */
    public static function LoggedIn()
    {
        OpenView('homepage.php');
    }

    /*
        Quand l'inscription n'est pas possible.
    */
    public static function BadRegister(RegisterErrorReason $reason)
    {
        OpenView('inscription.php');
    }

    /*
        Quand l'inscription s'est déroulée avec succès.
    */
    public static function Registered()
    {
        OpenView('homepage.php');
    }

    /*
        Quand un cours a été ajouté avec succès.
    */
    public static function LessonAdded()
    {
        OpenView('pageCours.php');
    }
}

?>