<?php

require_once __DIR__ . '/../../model/User.php';
require_once __DIR__ . '/Sessions.php';
require_once __DIR__ . '/../ViewLauncher.php';

/*
    Au chargement de la page, on va simplement appeler la fonction TryLogin, qui représente un endpoint pour cette page. C'est-à-dire que peu importe le résultat de TryLogin, une vue sera chargée à son issue.

    Utilisation : passer les paramètres en POST.
    'username' correspond au pseudonyme de l'utilisateur à connecter.
    'passwordNotHashed' correspond à son mot de passe en clair.
*/

if(isset($_POST['username']) && isset($_POST['passwordNotHashed']))
{
    LoginController::TryLogin(
        $_POST['username'], // Le login/pseudo de l'utilisateur
        $_POST['passwordNotHashed'], // Le mot de passe en clair de l'utilisateur
    );
}

class LoginController
{
    /**
     * Essaie de connecter un utilisateur.
     * Usage interne uniquement, utiliser des variables POST pour connecter un utilisateur.
     *
     * @param string $username Le nom d'utilisateur/pseudonyme.
     * @param string $passwordNotHashed Le mot de passe en clair.
     * @return void
     */
    public static function TryLogin(string $username, string $passwordNotHashed)
    {
        $userInstance = new User();
        $hashTarget = $userInstance->getMdpHash($username);

        // Si le hash est invalide (=> l'username n'existe pas) ou si le mot de passe ne correspond pas au mot de passe correspondant à l'username, alors on doit traiter l'erreur.
        if($hashTarget == 0 || !password_verify($passwordNotHashed, $hashTarget))
        {
            ViewLauncher::BadLogin();
            return;
        }
        
        // Sinon, on connecte la personne.
        $userData = $userInstance->getUtilisateur($username);
        Session::Create(
            $userData['login'],
            $userData['prenom'],
            $userData['nom'],
            $userData['email'],
            $userData['admin']
        );

        ViewLauncher::LoggedIn();
        return;
    }
}