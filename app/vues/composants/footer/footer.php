<?php
function footer()
{
    $html = <<<HTML
    <footer>
        <div id="copyright-wrapper">
            <h3 id="copyright">MOODLE | © 2023</h3>
        </div>
    </footer>
    <link rel="stylesheet" type="text/css" href="../../composants/footer/footer.css"/>
    <script src="../../composants/header/header.js"></script>
    HTML;
    echo $html;
}
?>
