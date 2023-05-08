<?php
function footer($lienStylePageFooter)
{
    $html = <<<HTML
    <footer>
        <div id="copyright-wrapper">
            <h3 id="copyright">MOODLE | © 2023</h3>
        </div>
    </footer>
    <link rel="stylesheet" type="text/css" href="$lienStylePageFooter"/>
    <script src="../../composants/header/header.js"></script>
    HTML;
    echo $html;
}
?>
