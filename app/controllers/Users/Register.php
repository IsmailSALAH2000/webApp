<?php

require_once '/app/model/User.php'
require_once '/app/controllers/Sessions.php'
require '/app/controllers/ViewsLauncher.php'

class Register 
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