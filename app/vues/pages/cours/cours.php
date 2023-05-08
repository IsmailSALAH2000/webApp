<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include '../../../controllers/Lessons/LessonController.php';
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Cours', '../../pages/cours/cours.css');?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); 
            $idCours = $_GET['id'];
            if($idCours == 0) {
                ViewLauncher::Error404();
            }
            ?>
        </header>

        <main>
            <?php 
                if($isLogged){
                    $isAdmin = Session::IsAdmin();
                    if($isAdmin) {
            ?>
                        <form method="post">
                            <input type="hidden" name="whatToDo" value="removeLesson">
                            <input type="hidden" name="lessonId" value=<?php echo $idCours; ?>>
                            <button type="submit" class="btn-modif">Supprimer ce cours</button>
                        </form>
            <?php
                    }

                    $cours = LessonController::GetLessonById($idCours);
                    if($cours == null) ViewLauncher::Error404();
                    else {
                        $titre = htmlspecialchars($cours['cours']->titre);
                        $description = htmlspecialchars($cours['cours']->description);
                        $type = htmlspecialchars($cours['cours']->type);
                        $chemin = htmlspecialchars($cours['cours']->chemin);
                        $dateCours = htmlspecialchars($cours['cours']->dateCours);
                        $format = htmlspecialchars($cours['format']);
            ?>        
                        <div class="cadreCours2">
                            <h3 class="titre"><?php echo $titre; ?></h3>
                            <div class="typeDate">
                                <div class="type"><?php echo $type; ?></div>
                                <div class="date"><?php echo $dateCours; ?></div>
                            </div>
                            <div class="description"><?php echo $description; ?></div>
                        </div>
            <?php 
                        if($format == ".mp4") {
            ?>
                            <video width="70%" controls>
                                <source src=<?php echo $chemin;?> type="video/mp4">
                            </video>
            <?php
                        }
                        else {
                            if($format == ".pdf") {
            ?>
                                <embed src=<?php echo $chemin;?> type="application/pdf" width="100%" height="1000px"/>
            <?php
                            }
                        }
                    }
                }
            ?>
        </main>

        <?php footer(); ?>
    </body>

</html>