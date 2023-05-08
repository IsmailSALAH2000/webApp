<?php
include('../../composants/header/header.php');
include('../../../controllers/Users/Sessions.php');
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Accueil', '../../pages/accueil/accueil.css');?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); ?>
        </header>

        <main>
        </main>
        
        <footer>
            <div id="copyright-wrapper">
                <h3 id="copyright">MOODLE | © 2023</h3>
            </div>
        </footer>
        
        <script src="../../composants/header/header.js"></script>
    </body>
</html>
