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
                $idTopic = $_GET['id'];
            ?>
        </header>

        <main>
            <?php 
                $topic = ForumController::GetFullTopic($idTopic);
                $titre = htmlspecialchars($topic->header->title);
                $creator = htmlspecialchars($topic->header->creator);
                $answerNumber = htmlspecialchars($topic->header->answersNumber);
                $id = htmlspecialchars($topic->header->id);
                $html=<<<HTML
                    <h1 class="titreTopic">$titre</h1>
                    <div class="full-topic">
                        <div class="topic-content">$titre</div>
                            <div class="bottom-full-topic">
                                <div class="creator-topic">$creator</div>
                                <div class="nb-answer-topic">$answerNumber</div>
                            </div>
                    </div>
                 HTML;
                echo $html;
            ?>
            <h3 class="sous-titrePage">Ajouter un message.</h3>

            <form method="post">
                <input type="hidden" name="whatToDo" value="addMessage">
                <input type="hidden" name="creatorLogin" value="<?php echo $user; ?>">
                <input type="text" name="message" placeholder="Ecrivez votre message." required>
                <button type="submit">Poster</button>
            </form>

            <h3 class="sous-titrePage">Réponses:</h3>

            <?php 
                if($isLogged){
                    $isAdmin = Session::IsAdmin();
                    $listeMessage = $topic->messages;
                    for ($i=0; $i < count($listeMessage) ; $i++) {
                        $creator = htmlspecialchars($listeMessage[$i]->author); 
                        $date = htmlspecialchars($listeMessage[$i]->date);
                        $content = htmlspecialchars($listeMessage[$i]->content);
                        $id = htmlspecialchars($listeMessage[$i]->id);
                        $html=<<<HTML
                            <div class="message">
                                <div class="message-header">
                                    <div class="message-creator">$creator</div>
                                    <div class="date-message">$date</div>
                                </div>
                                <div class="message-content">$content</div>
                        HTML;
                        echo $html;
                        
                        if ($isAdmin) {
                            $html=<<<HTML
                                    <form method="post">
                                        <input type="hidden" name="whatToDo" value="removeMessage">
                                        <input type="hidden" name="idTopic" value='{$idTopic}'>
                                        <input type="hidden" name="idMessage" value='{$id}'>
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </div>
                            HTML;
                            echo $html;
                        }
                        else{
                            echo '<div/>';
                        }
                    }
                }
            ?>
        </main>

        <?php footer(); ?>
    </body>

</html>