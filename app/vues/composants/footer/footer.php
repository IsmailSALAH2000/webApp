<?php
function footer()
{
    $html = <<<HTML
    <footer>
        <div id="copyright-wrapper">
            <p>MOODLE | © 2023</p>
        </div>
    </footer>
    <script src="/vues/composants/header/header.js"></script>
    HTML;
    echo $html;
}
?>