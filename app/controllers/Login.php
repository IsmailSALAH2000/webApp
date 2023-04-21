<?php
class Login 
{
    use Controller;
    public function index($data=[])
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $user = new User;

            $login = $_POST['login'];
            $mdp = $user->getMdpHash($login);
            if($mdp) {
                if($mdp == $_POST['mdpHash']){ //en réalité il faudra haché le mdp
                    //$_SESSION['EMAIL'] = $_POST['email'];
                    redirect('home');
                }
            }
            $user-> errors[] = "Invalid login or password";
            $data['errors'] = $user->errors; 
        }
        
        $this->view("login",$data);
    }
}