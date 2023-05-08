<?php
include('../../composants/header/header.php');
include('../../composants/footer/footer.php');
include('../../../controllers/Users/Sessions.php');
include '../../../controllers/Qcms/QCMController.php' ;

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
    $stylePage = '../../pages/qcm/darkQcm.css';
    $stylePageHeader = '../../composants/header/darkHeader.css';
    $stylePageFooter = '../../composants/footer/darkFooter.css';

} else {
    $stylePage = '../../pages/qcm/qcm.css';
    $stylePageHeader = '../../composants/header/header.css';
    $stylePageFooter = '../../composants/footer/footer.css';
}

if(isset($_POST['nouvQCM'])) {
    //on créer un nouveau qcm
    $qcm = new QCM();
    $qcm->header = new QCMHeader();
    $qcm->header->id = $_POST['titre'];;
    $qcm->header->type = $_POST['categorie'];

    // Parcourir chaque question
    for($i = 1; isset($_POST["question$i"]); $i++) {
        $q = new Question();
        $q->label =$_POST["question$i"];

        // Parcourir chaque réponse associée à la question courante
        for($j = 1; isset($_POST["reponse$i$j"]); $j++) {
            //$reponse = new Reponse();
            $a = new Answer();
            $a->label = $_POST["reponse$i$j"];
            $a->isCorrect = $_POST["correction$i$j"];
            array_push($q->answers, $a);
        }
        array_push($qcm->questions, $q);
    }
    QCMController::AddQCM($qcm);
}

if(isset($_POST['delQCM'])) {
    $qcmId = $_POST['titre'];
    QCMController::RemoveQCMById($qcmId);
}

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <?php head('QCM', $stylePage, $stylePageHeader);?>
    </head>

    <body>
        <header>
            <?php 
            $isLogged = Session::Exists();
            navBar($isLogged); ?>
        </header>

        <main>
        <button id="theme-button" onclick="ToggleTheme()"><?php echo $currentTheme === 'dark' ? 'Mode Clair' : 'Mode Sombre'; ?></button>
        <fieldset>
            <legend>Choisissez votre qcm.</legend>
            <form method="post" action="vueQCM.php">   

        <?php
        $headers = QCMController::GetAllQCMHeaders();
        foreach($headers as $h)
        {
            echo "<input type=\"checkbox\" name=\"QCMChoisi\" value=\"$h->id\"><p> $h->id </p><br>";
        }
        $isAdmin = Session::IsAdmin();
            if($isAdmin){
                echo "<button id=\"addQCM\" name=\"addQCM\"> + </button>";
                echo "<button id=\"supprQCM\"name=\"supprQCM\"> - </button> <br>";
            }
        ?>

            <button type="submit">C'est parti !</button>
            </form>
            </legend>
        </fieldset>
        
        
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
