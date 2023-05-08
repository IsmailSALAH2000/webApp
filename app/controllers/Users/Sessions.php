<?php

enum Theme
{
    case Bright;
    case Dark;
}

session_start();

class Session
{
    public static function Create($login, $firstName, $lastName, $mail, $isAdmin)
    {
        $_SESSION['login'] = $login;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['mail'] = $mail;
        $_SESSION['isAdmin'] = $isAdmin;
    }

    public static function Exists()
    {
        return isset($_SESSION['login']);
    }

    public static function GetTheme() : Theme
    {
        if(!isset($_SESSION['theme'])) 
            $_SESSION['theme'] = Theme::Bright;

        return $_SESSION['theme'];
    }

    public static function SetTheme(Theme $newTheme)
    {
        $_SESSION['theme'] = $newTheme;
    }

    public static function GetLogin()
    {
        if(!Session::Exists()) throw new Exception('Aucune session en cours. Impossible de récupérer le login : session non créée.');
        else return $_SESSION['login'];
    }

    public static function GetFirstName()
    {
        if(!Session::Exists()) throw new Exception('Aucune session en cours. Impossible de récupérer le prénom : session non créée.');
        else return $_SESSION['firstName'];
    }

    public static function GetLastName()
    {
        if(!Session::Exists()) throw new Exception('Aucune session en cours. Impossible de récupérer le nom : session non créée.');
        else return $_SESSION['lastName'];
    }

    public static function GetMail()
    {
        if(!Session::Exists()) throw new Exception('Aucune session en cours. Impossible de récupérer le mail : session non créée.');
        else return $_SESSION['mail'];
    }

    public static function IsAdmin()
    {
        if(!Session::Exists()) throw new Exception('Aucune session en cours. Impossible de récupérer la variable admin : session non créée.');
        else return $_SESSION['isAdmin'];
    }

    public static function Destroy()
    {
        session_destroy();
    }
}

?>