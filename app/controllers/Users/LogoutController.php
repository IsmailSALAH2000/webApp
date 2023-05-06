<?php

require_once __DIR__ . '/Sessions.php';
require_once __DIR__ . '/../ViewLauncher.php';

Session::Destroy();
ViewLauncher::LoggedOut();

?>