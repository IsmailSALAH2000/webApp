<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Qcms/QCMController.php' ;

// Vérifie si le formulaire a été soumis et que le thème a été sélectionné
if (isset($_POST['theme'])) {

    // Stocke le thème dans un cookie pendant 30 jours
    setcookie('theme', $_POST['theme'], time() + (30 * 24 * 60 * 60));
    // Redirige vers la page de connexion pour afficher le nouveau thème
    header('Location: connexion.php');
}

// Obtient le thème actuel à partir du cookie ou définit le thème clair par défaut
$currentTheme = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'dark' : 'light';

// Charge la feuille de style appropriée en fonction du thème
if ($currentTheme === 'dark') {
    $stylePage = '../../pages/qcm/darkVueQCM.css';
    $stylePageHeader = '../../composants/header/darkHeader.css';
    $stylePageFooter = '../../composants/footer/darkFooter.css';

} else {
    $stylePage = '../../pages/qcm/vueQCM.css';
    $stylePageHeader = '../../composants/header/header.css';
    $stylePageFooter = '../../composants/footer/footer.css';
}

?>



<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('votre QCM', $stylePage, $stylePageHeader);?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); ?>
        </header>

        <main>
            <button id="theme-button" onclick="ToggleTheme()"><?php echo $currentTheme === 'dark' ? 'Mode Clair' : 'Mode Sombre'; ?></button>
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
        <script>
        function ToggleTheme() {
            var currentTheme = '<?php echo $currentTheme; ?>';
            var newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.cookie = 'theme=' + newTheme + '; path=/; max-age=' + 30 * 24 * 60 * 60;
            location.reload();
        }
        </script>
        <?php footer($stylePageFooter); ?>
    </body>

</html>