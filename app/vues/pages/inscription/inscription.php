<?php
include('../../composants/header/header.php');;
include('../../composants/footer/footer.php');
include('../../../controllers/Users/RegisterController.php');
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Inscription', '../../pages/inscription/inscription.css');?>
    </head>

    <body>
        <header>
            <?php navBar(false); ?>
        </header>

        <main>
            <form method="post" action="../../../controllers/Users/RegisterController.php">
                <h2>INSCRIVEZ-VOUS</h2>
<!-- 
               <?php //if (isset($_GET['error'])) { ?>
     		        <p class="error"> <?php //echo $_GET['error']; ?></p>
                <?php //} ?>-->

                <label>Nom</label>
                <input type="text" name="lastName" required>

                <label>Prénom</label>
                <input type="text" name="firstName" required>

                <label>Email</label>
                <input type="email" name="mail" required>

                <label>Nom d'utilisateur</label>
                <input type="text" name="username" required>
                
                <label>Mot de passe</label>
                <input type="password" name="passwordNotHashed" required>

                <button type="submit">Inscription</button>
                <p>Déjà inscrit ? Connectez-vous <a href="../../pages/connexion/connexion.php">ici</a> .</p>
            </form>
            
        </main>

        <?php footer(); ?>
    </body>

</html>
