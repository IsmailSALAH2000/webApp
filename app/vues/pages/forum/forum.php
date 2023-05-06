<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Forum/ForumController.php';
//include('../../../controllers/Forum/ForumDataStructures.php');
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
            <?php 
                if($isLogged){
                    $isAdmin = Session::IsAdmin();
                    $listeTopics = ForumController::GetAllTopicHeaders();
                    for ($i=0; $i < count($listeTopics) ; $i++) { 
                        $titre = htmlspecialchars($listeTopics[$i]->title);
                        $html=<<<HTML
                            <a href="#">
                                <div class="topic-header">
                                    <div class="titre-topic">
                                            $titre
                                    </div>
                                </div>
                            </a>
                        HTML;
                        echo $html;
                    }
                }
            ?>
        </main>

        <?php footer(); ?>
    </body>

</html>