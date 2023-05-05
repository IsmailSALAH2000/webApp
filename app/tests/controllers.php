<?php

require_once '../controllers/Users/RegisterController.php';
require_once '../controllers/Users/LoginController.php';

//RegisterController::TryRegister('alex', 'motdepasse', 'Alexandre', 'Beaujon', 'alexandre@gmail.com');

//Session::Destroy();
//LoginController::TryLogin('alex', 'motdepasse');
echo '<br>';
echo 'Session existante: ' . (Session::Exists() ? 'true' : 'false');



?>