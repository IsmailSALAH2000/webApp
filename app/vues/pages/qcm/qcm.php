<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Qcms/QCMController.php' ;

$editQCM = function(){
    echo 'hello';
}


?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('QCM', '../../pages/qcm/qcm.css');?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); ?>
        </header>

        <main>
        <fieldset>
            <legend>Choisissez votre qcm.</legend>
            <form method="post" action="vueQCM.php">   

        <?php
        $headers = QCMController::GetAllQCMHeaders();
        foreach($headers as $h)
        {
            echo "<input type=\"checkbox\" name=\"QCMChoisi\" value=\"$h->id\"> $h->id <br>";
        }
        $Admin = true;
            if($Admin){
                echo "<button id=\"addQCM\" name=\"addQCM\"> + </button>";
                echo "<button id=\"supprQCM\"name=\"supprQCM\"> - </button> <br>";
            }
        ?>

            <button type="submit">C'est parti !</button>
            </form>
            </legend>
        </fieldset>
        
        
        </main>

        <?php footer(); ?>
    </body>

</html>
