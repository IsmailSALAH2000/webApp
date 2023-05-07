<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Qcms/QCMController.php' ;

function ajoutReponse(){
    echo <<<HTML
        <form id="editQCM" method="post">
        <label>Réponse</label>
        <input type="text" name="reponse" value="" required>
        <input type="radio" name="correction" value="true" required> Vrai
        <input type="radio" name="correction" value="false" required> Faux
        <button type="submit">ÉDITER</button>
    HTML;
}
?>



<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('votre QCM', '../../pages/qcm/vueQCM.css');?>
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
                <form id="editQCM" method="post">
                <h2>Editer votre QCM</h2>

                <label>Titre</label>
                <input type="text" name="titre" required>

                <label>Catégorie</label>
                <input type="text" name="catégorie" required>

                <label>Question</label>
                <input type="text" name="question" required>

                <label>Réponse</label>
                <input type="text" name="reponse" value="" required>
                <input type="radio" name="correction" value="true" required> Vrai
                <input type="radio" name="correction" value="false" required> Faux
                <button type="submit">ÉDITER</button>
            </form>
            HTML;
            
            echo '<button id="addReponse" onclick='.ajoutReponse().'> Autre réponse </button>';
            echo '<button id="addQuestion" > Autre question </button>';
            
        }
        else if(isset($_POST['supprQCM'])){
            echo "This is suppr that is selected";
        }
        else{
            $comptQuestion = 0;
            $score = 0;
            $idQCM = $_POST["QCMChoisi"];
            $qcmDetaille = QCMController::GetQCMById($idQCM);
            echo "<ol>";
                foreach($qcmDetaille->questions as $question)
                {
                    echo <<<HTML
                    <li>$question->label</li>
                    HTML;
                    foreach($question->answers as $answer)
                    {
                        echo "<input type=\"checkbox\" name=\"$comptQuestion\" value=\"$answer->label\">$answer->label<br>";
                        //if($answer->isCorrect)
                        // {$score=$score+1;}
                        //echo "<p style='color:" . ($answer->isCorrect ? 'green' : 'red') . ";'>";
                        //echo "$answer->label";
                        //echo "</p>";
                    }
                }
                <<<HTML
                <button type="input">Vérifier</button>
                </form>
                </legend>
            </fieldset>
            HTML;
        }?>
        </main>

        <?php footer(); ?>
    </body>

</html>