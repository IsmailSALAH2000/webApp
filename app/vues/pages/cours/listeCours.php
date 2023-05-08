<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include '../../../controllers/Lessons/LessonController.php';
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Liste cours', '../../pages/cours/cours.css');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#choixType').change(function(){
                    $('form').submit();
                });
            });
        </script>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); 
            ?>
        </header>

        <main>
            <?php 
                if($isLogged){
                    $isAdmin = Session::IsAdmin();
                    if($isAdmin) {
            ?>
                        <button class="btn-modif" onclick="window.location.href = 'ajoutCours.php'">Ajouter un cours</button>
            <?php
                    }
                    $listeTypes = LessonController::GetAllTypes();
            ?>
                    <div class="choix">
                        <h1 class="titreChoix">Choisissez un type de cours :</h1>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php
                            if(isset($_POST['choixType'])) $choixType = $_POST['choixType'];
                            else $choixType = 'Tous';
            ?>
                            <select name="choixType" id="choixType" class="selectChoix">
                                <?php 
                                    //choix par défaut (tous les cours)
                                    if($type == $choixType) $selected = 'selected';
                                    else $selected = '';
                                    echo '<option value="Tous"'.$selected.'>Tous</option>';
                                    //choix d'un type particulier
                                    foreach($listeTypes as $type) {
                                        if($type == $choixType) $selected = 'selected';
                                        else $selected = '';
                                        echo '<option value="'.$type.'"'.$selected.'>'.$type.'</option>';
                                    }
                                ?>
                            </select>
                        </form>
                    </div>
                    <br/>

            <?php
                    if (isset($_POST['choixType']) && $_POST['choixType']!='Tous') { //si on a choisi un type particulier
                        $type = $_POST['choixType'];
                        $listeCours = LessonController::GetAllLessonsOfType($type);
                    }
                    else { //tous les cours sélectionnés
                        $listeCours = LessonController::GetAllLessons();
                    }
                    
                    foreach($listeCours as $cours) { 
                        $idCours = htmlspecialchars($cours->idCours);
                        $titre = htmlspecialchars($cours->titre);
                        $description = htmlspecialchars($cours->description);
                        $type = htmlspecialchars($cours->type);
                        $chemin = htmlspecialchars($cours->chemin);
                        $dateCours = htmlspecialchars($cours->dateCours);

                        $html=<<<HTML
                            <a href="cours.php?id=$idCours">
                                <div class="cadreCours">
                                    <h2 class="titre">$titre</h2>
                                    <div class="typeDate">
                                        <div class="type">Type : $type</div>
                                        <div class="date">Date de publication : $dateCours</div>
                                    </div>
                                    <div class="description">Description : $description</div>
                                </div>
                            </a>
                            <br/>
                        HTML;
                        echo $html;
                    }
                }
            ?>
        </main>

        <?php footer(); ?>
    </body>

</html>