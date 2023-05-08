<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include '../../../controllers/Lessons/LessonController.php';

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
    $stylePage = '../../pages/cours/darkCours.css';
    $stylePageHeader = '../../composants/header/darkHeader.css';
    $stylePageFooter = '../../composants/footer/darkFooter.css';

} else {
    $stylePage = '../../pages/cours/cours.css';
    $stylePageHeader = '../../composants/header/header.css';
    $stylePageFooter = '../../composants/footer/footer.css';
}


?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Cours', $stylePage, $stylePageHeader);?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); 
            $idCours = $_GET['id'];
            if($idCours == 0) {
                ViewLauncher::Error404();
            }
            ?>
        </header>

        <main>
            <button id="theme-button" onclick="ToggleTheme()"><?php echo $currentTheme === 'dark' ? 'Mode Clair' : 'Mode Sombre'; ?></button>
            <?php 
                if($isLogged){
                    $isAdmin = Session::IsAdmin();
                    if($isAdmin) {
            ?>
                        <form method="post">
                            <input type="hidden" name="whatToDo" value="removeLesson">
                            <input type="hidden" name="lessonId" value=<?php echo $idCours; ?>>
                            <button type="submit" class="btn-modif">Supprimer ce cours</button>
                        </form>
            <?php
                    }

                    $cours = LessonController::GetLessonById($idCours);
                    if($cours == null) ViewLauncher::Error404();
                    else {
                        $titre = htmlspecialchars($cours['cours']->titre);
                        $description = htmlspecialchars($cours['cours']->description);
                        $type = htmlspecialchars($cours['cours']->type);
                        $chemin = htmlspecialchars($cours['cours']->chemin);
                        $dateCours = htmlspecialchars($cours['cours']->dateCours);
                        $format = htmlspecialchars($cours['format']);
            ?>        
                        <div class="cadreCours2">
                            <h3 class="titre"><?php echo $titre; ?></h3>
                            <div class="typeDate">
                                <div class="type"><?php echo $type; ?></div>
                                <div class="date"><?php echo $dateCours; ?></div>
                            </div>
                            <div class="description"><?php echo $description; ?></div>
                        </div>
            <?php 
                        if($format == ".mp4") {
            ?>
                            <video width="70%" controls>
                                <source src=<?php echo $chemin;?> type="video/mp4">
                            </video>
            <?php
                        }
                        else {
                            if($format == ".pdf") {
            ?>
                                <embed src=<?php echo $chemin;?> type="application/pdf" width="100%" height="1000px"/>
            <?php
                            }
                        }
                    }
                }
            ?>
        </main>

        <?php footer($stylePageFooter); ?>
        <script>
        function ToggleTheme() {
            var currentTheme = '<?php echo $currentTheme; ?>';
            var newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.cookie = 'theme=' + newTheme + '; path=/; max-age=' + 30 * 24 * 60 * 60;
            location.reload();
        }
        </script>
    </body>

</html>