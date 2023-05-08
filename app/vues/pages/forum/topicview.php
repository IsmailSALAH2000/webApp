<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Forum/ForumController.php';
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Forum', '../../pages/forum/topicview.css');?>
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
                $listeMessage = $topic->messages;
                $titre = htmlspecialchars($topic->header->title);
                $creator = htmlspecialchars($topic->header->creator);
                $answerNumber = htmlspecialchars($topic->header->answersNumber);
                $date = htmlspecialchars($listeMessage[0]->date);
                $content = htmlspecialchars($listeMessage[0]->content);
                $html=<<<HTML
                    <h1 class="titreTopic">$titre</h1>
                    <div class="full-topic">
                        <div class="bottom-full-topic">
                            <div class="creator-topic">Auteur: $creator</div>
                            <div class="nb-answer-topic">Réponse(s): $answerNumber</div>
                        </div>
                        <div class="content">$content</div>
                        <div class="date">Date de publication: $date</div>
                    </div>
                 HTML;
                echo $html;
            ?>
            <h3 class="sous-titrePage">Ajouter un message.</h3>

            <form method="post" id="create-message">
                <input type="hidden" name="whatToDo" value="addMessage">
                <input type="hidden" name="creatorLogin" value="<?php echo $user; ?>">
                <input type="hidden" name="idTopic" value="<?php echo $idTopic; ?>">
                <label for="messageContent">Votre message:</label>
                <textarea class="messageContent" name="messageContent" placeholder="Ecrivez votre message." required></textarea>
                <button type="submit" class="btn-modif">Poster</button>
            </form>

            <h3 class="sous-titrePage">Réponses:</h3>

            <?php 
                if($isLogged){
                    $isAdmin = Session::IsAdmin();
                    $html=<<<HTML
                    <h3 class="sous-titrePage">Réponses:</h3>
                    HTML;
                    for ($i=1; $i < count($listeMessage) ; $i++) {
                        $creator = htmlspecialchars($listeMessage[$i]->author); 
                        $date = htmlspecialchars($listeMessage[$i]->date);
                        $content = htmlspecialchars($listeMessage[$i]->content);
                        $id = htmlspecialchars($listeMessage[$i]->id);
                        $html=<<<HTML
                            <div class="message">
                                <div class="message-header">
                                    <div class="message-creator">Auteur: $creator</div>
                                    <div class="date-message">Date: $date</div>
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
                                        <button type="submit" class="btn-modif">Supprimer</button>
                                    </form>
                                </div>
                            HTML;
                            echo $html;
                        }
                        else{
                            $html=<<<HTML
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