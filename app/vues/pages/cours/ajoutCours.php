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
    $stylePage = '../../pages/cours/darkAjoutCours.css';
    $stylePageHeader = '../../composants/header/darkHeader.css';
    $stylePageFooter = '../../composants/footer/darkFooter.css';

} else {
    $stylePage = '../../pages/cours/ajoutCours.css';
    $stylePageHeader = '../../composants/header/header.css';
    $stylePageFooter = '../../composants/footer/footer.css';
}

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Ajouter un cours', $stylePage, $stylePageHeader);?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            $isAdmin = Session::IsAdmin();
            navBar($isLogged); 
            ?>
        </header>

        <main>
            <?php 
                if($isLogged && $isAdmin){
            ?>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="whatToDo" value="addLesson">

                        <label>Titre</label>
                        <input type="text" name="title" required>

                        <label>Description</label>
                        <input type="text" name="description" required>

                        <label>Type</label>
                        <input type="text" name="type" required>
            <?php
                        if(isset($_GET['error'])) {
                            echo '<label class="error">'.$_GET['error'].'</label>';
                        }
                        else {
                            echo '<label>Fichier contenant le cours</label>';
                        }
            ?>
                        <input type="file" name="file" class="inputFile" required>
                        
                        <button type="submit">Ajouter ce cours</button>
                    </form>

            <?php
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