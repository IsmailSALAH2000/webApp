<?php
//include('../../../controllers/Users/Sessions.php');

function head($titrePage, $lienStylePage, $lienStylePageHeader){
    $titrePage = htmlspecialchars($titrePage);
    $lienStylePage = htmlspecialchars($lienStylePage);

    $html=<<<HTML
        <title>$titrePage</title>
        <link rel="stylesheet" type="text/css" href="$lienStylePage"/>
        <link rel="stylesheet" type="text/css" href="$lienStylePageHeader"/>
        <meta charset="UTF-8"/>
        <meta name="author" content="BEAUJON Alexandre, MALOIGNE Anthony, PERE Brandon, ROBINET Perrine, SALAH Ismail, STRAINCHAMPS Clothilde" />
    HTML;
    echo $html;
}

function navBar($c){

    $connecter=function($c){
        if(!$c){
            $html=<<<HTML
                <li><a href="../../pages/inscription/inscription.php">S'INSCRIRE</a></li>
                <li><a href="../../pages/connexion/connexion.php">SE CONNECTER</a></li>
            HTML;
            return $html;
        }
        else{
            $user = Session::GetLogin();
            $html=<<<HTML
                <li><a href="../../pages/cours/listeCours.php">COURS</a></li>
                <li><a href="../../pages/qcm/qcm.php">QCM</a></li>
                <li><a href="../../pages/forum/forum.php">FORUM</a></li>
                <li><a href="#" class="btnConnection"></a>$user</li>
                <li><a href="../../../controllers/Users/LogoutController.php">SE DECONNECTER</a></li>
                <!-- <ul class="menuConnection">
                    <li><a href="#" class="choixMenu">Paramètres</a></li>
                    <li><a href="#" class="choixMenu">Déconnexion</a></li>
                </ul>-->
            HTML;
            return $html;
        }
    };

    $html=<<<HTML
        <header>
            <nav class="navbar">
                <a href="../../pages/accueil/accueil.php" class="logo">MOODLE</a>
                <div class="nav-links">
                    <ul>
                        {$connecter($c)}
                    </ul>
                </div>
                <img src="../../composants/header/menu-btn.png" alt="menu" class="menu-hamburger">
            </nav>
        </header>
    HTML;
    echo $html;
}
?>
