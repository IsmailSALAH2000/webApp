<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include '../../../controllers/Lessons/LessonController.php';
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Ajouter un cours', '../../pages/cours/ajoutCours.css');?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            $isAdmin = Session::IsAdmin();
            navBar($isLogged); 
            ?>
        </header>

        <main>
            <?php 
                if($isLogged && $isAdmin){
            ?>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="whatToDo" value="addLesson">

                        <label>Titre</label>
                        <input type="text" name="title" required>

                        <label>Description</label>
                        <input type="text" name="description" required>

                        <label>Type</label>
                        <input type="text" name="type" required>
            <?php
                        if(isset($_GET['error'])) {
                            echo '<label class="error">'.$_GET['error'].'</label>';
                        }
                        else {
                            echo '<label>Fichier contenant le cours</label>';
                        }
            ?>
                        <input type="file" name="file" class="inputFile" required>
                        
                        <button type="submit">Ajouter ce cours</button>
                    </form>

            <?php
                }
            ?>
        </main>

        <?php footer(); ?>
    </body>

</html>