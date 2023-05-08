<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');

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
    $stylePage = '../../pages/connexion/darkConnexion.css';
    $stylePageHeader = '../../composants/header/darkHeader.css';
    $stylePageFooter = '../../composants/footer/darkFooter.css';

} else {
    $stylePage = '../../pages/connexion/connexion.css';
    $stylePageHeader = '../../composants/header/header.css';
    $stylePageFooter = '../../composants/footer/footer.css';
}

?>


<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Connexion', $stylePage, $stylePageHeader);?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); ?>
        </header>

        <main>
        <button id="theme-button" onclick="ToggleTheme()"><?php echo $currentTheme === 'dark' ? 'Mode Clair' : 'Mode Sombre'; ?></button>
            <form method="post" action="../../../controllers/Users/LoginController.php">
                <h2>CONNECTEZ-VOUS</h2>

                <label>Nom d'utilisateur :</label>
                <input type="text" name="username" required>
                
                <label>Mot de passe :</label>
                <input type="password" name="passwordNotHashed" required>

                <button type="submit">Connexion</button>
                <p>Pas encore inscrit ? Inscrivez-vous <a href="../inscription/inscription.php">ici</a> .</p>
            </form>
            
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
