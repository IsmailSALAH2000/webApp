<?php
class Signup 
{
    use Controller;
    public function index($data=[])
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user = new User;
            $login = $_POST['login'];
            $mdp = $_POST['password']; //en réalité il faudra haché le mdp
            if($user->ajoutUtilisateur($login, $mdp)) {
                redirect('home');
            }
            $user-> errors[] = "Login non disponible";
            $data['errors'] = $user->errors; 
        }
        

        $this->view("signup", $data);
    }
}