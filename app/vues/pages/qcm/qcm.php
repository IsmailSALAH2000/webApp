<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Qcms/QCMController.php' ;

if(isset($_POST['nouvQCM'])) {
    $qcm = new QCM();
    $qcm->header = new QCMHeader();
    $qcm->header->id = $_POST['titre'];
    $qcm->header->type = $_POST['categorie'];
    for($i=1; $i<3; $i++){
        //$q = new Question();
        echo $_POST["question$i"];
        for($j=1; $j<3; $j++){
            //$a = new Answer();
            echo $_POST["reponse$j"];
            echo $_POST["correction$j"];
            //array_push($q->answers, $a);
        }

    }
}

/*
if(isset($_POST['nouvQCM'])) {
    $i=0;

    echo $_POST['titre'];
    echo $_POST['categorie'];
    echo isset($_POST['question$i']);
        $q = new Question();
        $q->label = $_POST["question$i"];
        $i++;
        $j=0;
        while(isset($_POST['reponse$j'])){
            $a = new Answer();
            $a->label = $_POST["reponse$j"];
            $a->isCorrect = $_POST["correction$j"];
            array_push($q->answers, $a);
        }

    }
}*/

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
