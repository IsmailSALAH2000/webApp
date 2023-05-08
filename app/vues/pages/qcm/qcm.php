<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Qcms/QCMController.php' ;

if(isset($_POST['nouvQCM'])) {
    //on créer un nouveau qcm
    $qcm = new QCM();
    $qcm->header = new QCMHeader();
    $qcm->header->id = $_POST['titre'];;
    $qcm->header->type = $_POST['categorie'];

    // Parcourir chaque question
    for($i = 1; isset($_POST["question$i"]); $i++) {
        $q = new Question();
        $q->label =$_POST["question$i"];

        // Parcourir chaque réponse associée à la question courante
        for($j = 1; isset($_POST["reponse$i$j"]); $j++) {
            //$reponse = new Reponse();
            $a = new Answer();
            $a->label = $_POST["reponse$i$j"];
            $a->isCorrect = $_POST["correction$i$j"];
            array_push($q->answers, $a);
        }
        array_push($qcm->questions, $q);
    }
    QCMController::AddQCM($qcm);
}

if(isset($_POST['delQCM'])) {
    $qcmId = $_POST['titre'];
    QCMController::RemoveQCMById($qcmId);
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
        $isAdmin = Session::IsAdmin();
            if($isAdmin){
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
