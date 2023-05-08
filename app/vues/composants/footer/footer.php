<?php
function footer()
{
    $html = <<<HTML
    <footer>
        <div id="copyright-wrapper">
            <h3 id="copyright">MOODLE | © 2023</h3>
        </div>
    </footer>
    <script src="../../composants/header/header.js"></script>
    HTML;
    echo $html;
}
?>
