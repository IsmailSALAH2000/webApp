<?php

require_once __DIR__ . '/../../model/User.php';
require_once __DIR__ . '/Sessions.php';
require_once __DIR__ . '/../ViewLauncher.php';

/*
    Au chargement de la page, on va simplement appeler la fonction TryRegister, qui représente un endpoint pour cette page. C'est-à-dire que peu importe le résultat de TryRegister, une vue sera chargée à son issue.

    Utilisation : passer les paramètres en POST.
    'username' correspond au pseudonyme de l'utilisateur à connecter.
    'passwordNotHashed' correspond à son mot de passe en clair.
    'firstName' correspond à son prénom.
    'lastName' correspond à son nom de famille.
    'mail' correspond à son adresse mail.
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
    /**
     * Essaie d'inscrire un utilisateur.
     * Usage interne uniquement, utiliser des variables POST pour inscrire un utilisateur.
     *
     * @param string $username Le nom d'utilisateur/pseudonyme.
     * @param string $passwordNotHashed Le mot de passe en clair.
     * @param string $firstName Le prénom de l'utilisateur.
     * @param string $lastName Le nom de famille de l'utilisateur.
     * @param string $mail L'adresse mail de l'utilisateur.
     * @return void
     */
    public static function TryRegister(string $username, string $passwordNotHashed, string $firstName, string $lastName, string $mail)
    {
        $userInstance = new User();

        // On vérifie si le login n'est pas déjà pris
        if(!$userInstance->loginDisponible($username))
        {
            ViewLauncher::BadRegister(RegisterErrorReason::LoginAlreadyUsed);
            return;
        }
        
        // Traitement du mot de passe (doit être suffisamment fort)
        if(strlen($passwordNotHashed) < 5)
        {
            ViewLauncher::BadRegister(RegisterErrorReason::PasswordNotStrongEnough);
            return;
        }

        // Encryption du mot de passe
        $hash = password_hash($passwordNotHashed, PASSWORD_DEFAULT);

        if(!$userInstance->ajoutUtilisateur($username, $hash, $mail))
        {
            ViewLauncher::BadRegister(RegisterErrorReason::UnknownError);
            return;
        }
        
        if(!$userInstance->modifierPrenomUtilisateur($username, $firstName))
        {
            ViewLauncher::BadRegister(RegisterErrorReason::UnknownError);
            return;
        }
        
        if(!$userInstance->modifierNomUtilisateur($username, $lastName))
        {
            ViewLauncher::BadRegister(RegisterErrorReason::UnknownError);
            return;
        }
        
        if(!$userInstance->modifierEmailUtilisateur($username, $mail))
        {
            ViewLauncher::BadRegister(RegisterErrorReason::UnknownError);
            return;
        }
        
        $userData = $userInstance->getUtilisateur($username);
        Session::Create(
            $userData['login'],
            $userData['prenom'],
            $userData['nom'],
            $userData['email'],
            $userData['admin']
        );

        ViewLauncher::Registered();
        return;
    }
}