<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Qcms/QCMController.php' ;
?>



<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('votre QCM', '../../pages/qcm/vueQCM.css');?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); ?>
        </header>

        <main>
            
        <?php
        if(isset($_POST['addQCM'])) { 
            echo <<<HTML
                <form id="editQCM" method="post" action="qcm.php">
                <h2>Editer votre QCM</h2>

                <button type="submit" name="nouvQCM" value="1">Envoyer</button><br>

                <label>Titre du QCM</label>
                <input type="text" name="titre"><br>

                <label>Catégorie</label>
                <input type="text" name="categorie"><br>

                <button type="button" id="addQuestion">Nouvelle question</button>
                
                </form>
            HTML;        
        }
        else if(isset($_POST['supprQCM'])){
            echo <<<HTML
                <form method="post" action="qcm.php">
                <h2>SUPPRIMER UN QCM</h2>

                <label>Titre du QCM</label>
                <input type="text" name="titre"><br>

                <button type="submit" name="delQCM" value="1">Supprimer</button><br>

                </form>
            HTML;       
        }
        else if(isset($_POST['QCMChoisi'])){
            $idQCM = $_POST["QCMChoisi"];
            $qcmDetaille = QCMController::GetQCMById($idQCM);
            echo    "<form method=\"post\" action=\"vueQCM.php\">
                    <input type=\"hidden\" name=\"nomQCM\" value=\"$idQCM\">
                    <h2>QCM: $idQCM</h2>
                    <ol>";
                foreach($qcmDetaille->questions as $question)
                {
                    echo <<<HTML
                    <li>$question->label</li>
                    HTML;
                    foreach($question->answers as $answer)
                    {
                        echo "<input type=\"checkbox\" class=\"checkbox\" name=\"$answer->label\" value=\"$answer->isCorrect\"><label>$answer->label</label><br>";
                    }
                }
                echo <<<HTML
                <button type="submit" name="verifQCM">Vérifier</button>
                </form>
            HTML;
        }
        else if(isset($_POST['verifQCM'])){
            $qcmDetaille = QCMController::GetQCMById($_POST['nomQCM']);
            $bonnesReponses = 0;
            foreach($qcmDetaille->questions as $question){
                foreach($question->answers as $answer){
                    
                    if(isset($_POST[$answer->label])){
                        if($_POST[$answer->label] == true){
                            $bonnesReponses++;
                        }
                    }
                }
            }
            echo "<h1>Vous avez $bonnesReponses bonnes réponses !</h1>";
            echo '<h2>Voici la correction</h2>';
            $i=1;
            echo '<div id="correction">';
            foreach($qcmDetaille->questions as $question)
            {
                echo "<p>Question $i: $question->label</li>";
                $i++;
                foreach($question->answers as $answer)
                {
                    echo "<p style='color:" . ($answer->isCorrect ? 'green' : 'red') . ";'>";
                    echo "$answer->label";
                    echo "</p>";
                }
            }
            echo '</div>';
        }
        ?>
        </main>
        <script src="vueQCM.js"></script>
        
        <?php footer(); ?>
    </body>

</html>