<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include '../../../controllers/Lessons/LessonController.php';


// Vérifie si le formulaire a été soumis et que le thème a été sélectionné
if (isset($_POST['theme'])) {

    // Stocke le thème dans un cookie pendant 30 jours
    setcookie('theme', $_POST['theme'], time() + (30 * 24 * 60 * 60));
    // Redirige vers la page de connexion pour afficher le nouveau thème
    header('Location: connexion.php');
}

// Obtient le thème actuel à partir du cookie ou définit le thème clair par défaut
$currentTheme = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'dark' : 'light';

// Charge la feuille de style appropriée en fonction du thème
if ($currentTheme === 'dark') {
    $stylePage = '../../pages/cours/darkCours.css';
    $stylePageHeader = '../../composants/header/darkHeader.css';
    $stylePageFooter = '../../composants/footer/darkFooter.css';

} else {
    $stylePage = '../../pages/cours/cours.css';
    $stylePageHeader = '../../composants/header/header.css';
    $stylePageFooter = '../../composants/footer/footer.css';
}

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('Liste cours', $stylePage, $stylePageHeader);?>
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

        <?php footer($stylePageFooter); ?>
        <script>
        function ToggleTheme() {
            var currentTheme = '<?php echo $currentTheme; ?>';
            var newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.cookie = 'theme=' + newTheme + '; path=/; max-age=' + 30 * 24 * 60 * 60;
            location.reload();
        }
        </script>
    </body>

</html>