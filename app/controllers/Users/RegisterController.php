<?php

require_once '/app/model/User.php'
require_once '/app/controllers/Sessions.php'
require_once '/app/controllers/ViewsLauncher.php'

/*
    Au chargement de la page, on va simplement appeler la fonction TryRegister, qui représente un endpoint pour cette page. C'est-à-dire que peu importe le résultat de TryRegister, une vue sera chargée à son issue.

    Utilisation : passer les paramètres en POST.
*/

if(isset($_POST['username'])
    && isset($_POST['passwordNotHashed'])
    && isset($_POST['firstName'])
    && isset($_POST['lastName'])
    && isset($_POST['mail']))
{
    RegisterController::TryRegister(
        $_POST['username'], // Le login/pseudo de l'utilisateur
        $_POST['passwordNotHashed'], // Le mot de passe en clair de l'utilisateur
        $_POST['firstName'], // Le prénom de l'utilisateur
        $_POST['lastName'], // Le nom de famille de l'utilisateur
        $_POST['mail'] // L'adresse mail de l'utilisateur
    );
}

class RegisterController 
{
    public static function TryRegister($username, $passwordNotHashed, $firstName, $lastName, $mail)
    {
        $userInstance = new User();

        // On vérifie si le login n'est pas déjà pris
        if(!$userInstance->loginDisponible($username))
        {
            ViewsLauncher::BadRegister(RegisterErrorReason::LoginAlreadyUsed);
            return;
        }
        
        // Traitement du mot de passe (doit être suffisamment fort)
        if(strlen($passwordNotHashed) < 5)
        {
            ViewsLauncher::BadRegister(RegisterErrorReason::PasswordNotStrongEnough);
            return;
        }

        // Encryption du mot de passe
        $hash = password_hash($passwordNotHashed, PASSWORD_DEFAULT);

        if(!$userInstance->ajoutUtilisateur($username, $hash))
        {
            ViewsLauncher::BadRegister(RegisterErrorReason::UnknownReason);
            return;
        }
        
        if(!$userData->modifierPrenomUtilisateur($username, $firstName))
        {
            ViewsLauncher::BadRegister(RegisterErrorReason::UnknownReason);
            return;
        }
        
        if(!$userData->modifierNomUtilisateur($username, $lastName))
        {
            ViewsLauncher::BadRegister(RegisterErrorReason::UnknownReason);
            return;
        }
        
        if(!$userData->modifierEmailUtilisateur($username, $mail))
        {
            ViewsLauncher::BadRegister(RegisterErrorReason::UnknownReason);
            return;
        }
        
        $userData = $userInstance->getUtilisateur();
        Session::CreateSession(
            $userData['login'],
            $userData['prenom'],
            $userData['nom'],
            $userData['email'],
            $userData['admin']
        );

        ViewsLauncher::Registered();
    }
}