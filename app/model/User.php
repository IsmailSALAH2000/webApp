<?php

require_once __DIR__ . '/Model.php';

class User {
    use Model;
    protected $table = "Utilisateur";
    /*
    protected $allowedColums = [
        'login',
        'password',
    ];*/

    public function getMdpHash($login) {
        $data['login'] = $login;
        $user = $this->select($data);
        if($user) {
            return $user['mdpHash'];
        }
        return 0; //échec
    }

    public function getUtilisateur($login) {
        $data['login'] = $login;
        $user = $this->select($data);
        if($user) {
            return $user;
        }
        return 0;
    }

    public function getUserByMail($email) {
        $data['email'] = $email;
        $user = $this->select($data);
        if($user) {
            return $user;
        }
        return 0;
    }

    public function loginDisponible($login) {
        $data['login'] = $login;
        $user = $this->select($data);
        if($user) {
            return 0;
        }
        return 1;
    }

    public function mailDisponible($email) {
        $data['email'] = $email;
        $user = $this->select($data);
        if($user) {
            return 0;
        }
        return 1;
    }

    public function ajoutUtilisateur($login, $mdpHash, $email) {
        if($this->loginDisponible($login) && $this->mailDisponible($email)) {
            $data['login'] = $login;
            $data['mdpHash'] = $mdpHash;
            $data['email'] = $email;
            if(is_array($this->insert($data))) {
                return 1;
            }
        }
        return 0; //login ou mail non dispo ou erreur lors de l'ajout
    }

    public function ajoutUtilisateur2($login, $mdpHash, $email, $nom, $prenom) {
        if($this->loginDisponible($login) && $this->mailDisponible($email)) {
            $data['login'] = $login;
            $data['mdpHash'] = $mdpHash;
            $data['email'] = $email;
            $data['nom'] = $nom;
            $data['prenom'] = $prenom;
            if(is_array($this->insert($data))) {
                return 1;
            }
        }
        return 0; //login ou mail non dispo ou erreur lors de l'ajout
    }

    public function modifierLoginUtilisateur($login, $nouveauLogin) {
        if($this->loginDisponible($nouveauLogin)) {
            $data['login'] = $nouveauLogin;
            if(is_array($this->update($login, $data, 'login'))) {
                return 1;
            }
        }
        return 0;//erreur
    }

    public function modifierMdpUtilisateur($login, $mdpHash) {
        $data['mdpHash'] = $mdpHash;
        if(is_array($this->update($login, $data, 'login'))) {
            return 1;
        }
        return 0;//erreur
    }

    public function modifierNomUtilisateur($login, $nom) {
        $data['nom'] = $nom;
        if(is_array($this->update($login, $data, 'login'))) {
            return 1;
        }
        return 0;//erreur
    }

    public function modifierPrenomUtilisateur($login, $prenom) {
        $data['prenom'] = $prenom;
        if(is_array($this->update($login, $data, 'login'))) {
            return 1;
        }
        return 0;//erreur
    }

    public function modifierEmailUtilisateur($login, $email) {
        $data['email'] = $email;
        if(is_array($this->update($login, $data, 'login'))) {
            return 1;
        }
        return 0;//erreur
    }
/*
    public function modifierUtilisateur($login, $nouveauLogin, $mdpHash, $nom, $prenom, $email) {
        $data['login'] = $login;
        $data['mdpHash'] = $mdpHash;
        $data['nom'] = $nom;
        $data['prenom'] = $prenom;
        $data['email'] = $email;
    }
*/
    public function supprimerUtilisateur($login) {
        if(is_array($this->delete($login, 'login'))) {
            return 1;
        }
        return 0;//erreur
    }

    public function setAdmin($login, $value) { //value : 0 pour false, 1 pour true
        $data['admin'] = $value;
        if(is_array($this->update($login, $data, 'login'))) {
            return 1;
        }
        return 0;//erreur
    }

/*
    public function validate($data){
        $this->errors = [];

        //pas ici ces vérifs mais dans controleur
        if(empty($data['email'])){
            $this->errors['email'] = "Email is required";
        }else
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $this->errors['email'] = "Email is not valid";
        }
        if(empty($data['password'])){
            $this->errors['password'] = "Password is required";
        }
        if(empty($this->errors)){
            return true;
        }
        return false;
    }*/
}