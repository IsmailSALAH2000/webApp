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

                <button type="submit" name="nouvQCM">Envoyer</button><br>

                <label>Titre du QCM</label>
                <input type="text" name="titre"><br>

                <label>Catégorie</label>
                <input type="text" name="categorie"><br>

                <button type="button" id="addQuestion">Nouvelle question</button>
                
                </form>
            HTML;

            
        }
        else if(isset($_POST['supprQCM'])){
            echo "This is suppr that is selected";
        }
        elseif(isset($_POST['QCMChoisi'])){
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
        <script src="vueQCM.js"></script>
        
        <?php footer(); ?>
    </body>

</html>