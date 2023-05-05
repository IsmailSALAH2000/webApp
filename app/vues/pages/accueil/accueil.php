<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
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

        <?php footer(); ?>
    </body>

</html>
