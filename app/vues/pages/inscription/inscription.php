<?php
include('../../composants/header/header.php');;
include('../../composants/footer/footer.php');
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Inscription', '/vues/pages/inscription/inscription.css');?>
    </head>

    <body>
        <header>
            <?php navBar(false); ?>
        </header>

        <main>
            <form action="verifConnexion a creer par le controleur.php" method="post">
                <h2>INSCRIVEZ-VOUS</h2>
<!-- 
               <?php //if (isset($_GET['error'])) { ?>
     		        <p class="error"> <?php //echo $_GET['error']; ?></p>
                <?php //} ?>-->

                <label>Nom</label>
                <input type="text" name="nom" required>

                <label>Prénom</label>
                <input type="text" name="prenom" required>

                <label>Prénom</label>
                <input type="email" name="email" required>

                <label>Nom d'utilisateur</label>
                <input type="text" name="nomUtilisateur" required>
                
                <label>Mot de passe</label>
                <input type="password" name="motDePasse" required>

                <button type="submit">Inscription</button>
                <p>Déjà inscrit ? Connectez-vous <a href="/vues/pages/connexion/connexion.php">ici</a> .</p>
            </form>
            
        </main>

        <?php footer(); ?>
    </body>

</html>
