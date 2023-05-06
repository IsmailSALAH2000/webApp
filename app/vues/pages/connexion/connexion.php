<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Connexion', '../../pages/connexion/connexion.css');?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); ?>
        </header>

        <main>
            <form method="post" action="../../../controllers/Users/LoginController.php">
                <h2>CONNECTEZ-VOUS</h2>
<!-- 
               <?php //if (isset($_GET['error'])) { ?>
     		        <p class="error"> <?php //echo $_GET['error']; ?></p>
                <?php //} ?>-->
                <label>Nom d'utilisateur :</label>
                <input type="text" name="username" required>
                
                <label>Mot de passe :</label>
                <input type="password" name="passwordNotHashed" required>

                <button type="submit">Connexion</button>
                <p>Pas encore inscrit ? Inscrivez-vous <a href="../inscription/inscription.php">ici</a> .</p>
            </form>
            
        </main>

        <?php footer(); ?>
    </body>

</html>
