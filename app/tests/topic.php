<?php

require_once '../controllers/Forum/ForumController.php';

if(!isset($_GET['id'])) ViewLauncher::Error404();

$fullTopic = ForumController::GetFullTopic($_GET['id']);

if($fullTopic == null) ViewLauncher::Error404();

echo "<h1>" . $fullTopic->header->title . "</h1>";
echo "<h2>Par " . $fullTopic->header->creator . "</h2>";

foreach($fullTopic->messages as $msg)
{
    echo "<p>" . $msg->author . " a dit le " . $msg->date . " :</p>";
    echo "<p>" . $msg->content . "</p>";
}

?>