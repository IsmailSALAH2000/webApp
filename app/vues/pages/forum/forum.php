<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Forum/ForumController.php';
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Forum', '../../pages/forum/forum.css');?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); 
            $user = Session::GetLogin();
            ?>
        </header>

        <main>
            <h1 class="titrePage">Bienvenue sur le forum !</h1>
            <h3 class="sous-titrePage">Créer un topic.</h3>

            <form method="post" id="create-post">
                <input type="hidden" name="whatToDo" value="addTopic">
                <input type="hidden" name="creatorLogin" value="<?php echo $user; ?>">
                <label for="title">Titre:</label>
                <textarea class="create-title" name="title" placeholder="Titre de votre poste." required></textarea>
                <label for="firstMessageContent">Contenu:</label>
                <textarea class="first-message" name="firstMessageContent" placeholder="Ecrivez votre message." required></textarea>
                <button type="submit" class="btn-modif">Poster</button>
            </form>

            <h3 class="sous-titrePage">Voir les topics existants.</h3>

            <?php 
                if($isLogged){
                    $isAdmin = Session::IsAdmin();
                    $listeTopics = ForumController::GetAllTopicHeaders();
                    for ($i=0; $i < count($listeTopics) ; $i++) { 
                        $titre = htmlspecialchars($listeTopics[$i]->title);
                        $creator = htmlspecialchars($listeTopics[$i]->creator);
                        $answerNumber = htmlspecialchars($listeTopics[$i]->answersNumber);
                        $id = htmlspecialchars($listeTopics[$i]->id);
                        $html=<<<HTML
                                <div class="topic-header">
                                    <a href='topicView.php?id={$id}'>
                                    <div class="bottom-topic-header">
                                        <div class="creator-topic">Auteur: $creator</div>
                                        <div class="nb-answer-topic">Réponse(s): $answerNumber</div>
                                    </div>
                                    <h2 class="titre-topic">$titre</h2>
                        HTML;
                        echo $html;
                        
                        if ($isAdmin) {
                            $html=<<<HTML
                                    <form method="post">
                                        <input type="hidden" name="whatToDo" value="removeTopic">
                                        <input type="hidden" name="id" value='{$id}'>
                                        <button type="submit" class="btn-modif">Supprimer</button>
                                    </form>
                                    </a>
                                </div>
                            HTML;
                            echo $html;
                        }
                        else{
                            $html=<<<HTML
                                </a>
                            </div>
                            HTML;
                            echo $html;
                        }
                    }
                }
            ?>
        </main>

        <?php footer(); ?>
    </body>

</html> 