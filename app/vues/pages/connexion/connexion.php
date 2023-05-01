<?php
include('/Applications/MAMP/htdocs/vues/composants/header/header.php');;
include('/Applications/MAMP/htdocs/vues/composants/footer/footer.php');
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Connexion', '/vues/pages/connexion/connexion.css');?>
    </head>

    <body>
        <header>
            <?php navBar(false); ?>
        </header>

        <main>
            <form action="verifConnexion a creer par le controleur.php" method="post">
                <h2>CONNECTEZ-VOUS</h2>
<!-- 
               <?php //if (isset($_GET['error'])) { ?>
     		        <p class="error"> <?php //echo $_GET['error']; ?></p>
                <?php //} ?>-->
                <label>Nom d'utilisateur :</label>
                <input type="text" name="nomUtilisateur" required>
                
                <label>Mot de passe :</label>
                <input type="password" name="motDePasse" required>

                <button type="submit">Connexion</button>
                <p>Pas encore inscrit ? Inscrivez-vous <a href="/vues/pages/inscription/inscription.php">ici</a> .</p>
            </form>
            
        </main>

        <?php footer(); ?>
    </body>

</html>