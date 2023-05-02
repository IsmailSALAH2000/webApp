<?php

require_once '/app/model/User.php'
require_once '/app/controllers/Sessions.php'
require '/app/controllers/ViewsLauncher.php'

class Login 
{
    public static function TryLogin($username, $passwordNotHashed)
    {
        $userInstance = new User();
        $hashTarget = $userInstance->getMdpHash($username);

        // Si le hash est invalide (=> l'username n'existe pas) ou si le mot de passe ne correspond pas au mot de passe correspondant à l'username, alors on doit traiter l'erreur.
        if($hashTarget == 0 || password_hash($passwordNotHashed, PASSWORD_DEFAULT) != $hashTarget)
        {
            ViewsLauncher::BadLogin();
            return;
        }
        
        // Sinon, on connecte la personne.
        $userData = $userInstance->getUtilisateur();
        Session::CreateSession(
            $userData['login'],
            $userData['prenom'],
            $userData['nom'],
            $userData['email']
        );

        ViewsLauncher::LoggedIn();
    }
}