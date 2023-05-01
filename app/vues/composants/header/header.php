<?php

function head($titrePage, $lienStylePage){
    $titrePage = htmlspecialchars($titrePage);
    $lienStylePage = htmlspecialchars($lienStylePage);

    $html=<<<HTML
        <title>$titrePage</title>
        <link rel="stylesheet" type="text/css" href="$lienStylePage"/>
        <link rel="stylesheet" type="text/css" href="/vues/composants/header/header.css"/>
        <link rel="stylesheet" type="text/css" href="/vues/composants/footer/footer.css"/>
        <meta charset="UTF-8"/>
        <meta name="author" content="BEAUJON Alexandre, MALOIGNE Anthony, PERE Brandon, ROBINET Perrine, SALAH Ismail, STRAINCHAMPS Clothilde" />
    HTML;
    echo $html;
}

function navBar($c){

    $connecter=function($c){
        if(!$c){
            $html=<<<HTML
                <li><a href="/vues/pages/connexion/connexion.php">COURS</a></li>
                <li><a href="/vues/pages/connexion/connexion.php">QCM</a></li>
                <li><a href="/vues/pages/connexion/connexion.php">FORUM</a></li>
                <li><a href="/vues/pages/connexion/connexion.php">SE CONNECTER</a></li>
            HTML;
            return $html;
        }
        else{
            $html=<<<HTML
                <li><a href="/vues/pages/cours/cours.php">COURS</a></li>
                <li><a href="/vues/pages/qcm/qcm.php">QCM</a></li>
                <li><a href="/vues/pages/forum/forum.php">FORUM</a></li>
                <li><a href="#" class="btnConnection">USER ID</a></li>
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
                <a href="#" class="logo">MOODLE</a>
                <div class="nav-links">
                    <ul>
                        {$connecter($c)}
                    </ul>
                </div>
                <img src="/vues/composants/header/menu-btn.png" alt="menu" class="menu-hamburger">
            </nav>
        </header>
    HTML;
    echo $html;
}
?>