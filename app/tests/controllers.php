<?php

// Users ==> OK
require_once '../controllers/Users/RegisterController.php';
require_once '../controllers/Users/LoginController.php';

// Lessons ==> OK
require_once '../controllers/Lessons/LessonController.php';

// Qcms ==> OK
require_once '../controllers/Qcms/QCMController.php';

// Forum ==> en cours de test
require_once '../controllers/Forum/ForumController.php';

//RegisterController::TryRegister('alex', 'motdepasse', 'Alexandre', 'Beaujon', 'alexandre@gmail.com');

//Session::Destroy();
//LoginController::TryLogin('alex', 'motdepasse');

/*

echo '<br>';
echo 'Session existante: ' . (Session::Exists() ? 'true' : 'false');
echo '<br>';
if(Session::Exists()) echo "Admin ? : " . Session::IsAdmin();
echo '<br>';

*/

/*

Lesson: $lesson = new Lesson();
$lesson->chemin = 'https://www.youtube.com/watch?v=hJnbt2Cu1Es';
$lesson->titre = 'Les espaces vectoriels';
$lesson->description = 'Cours introductif sur les espaces vectoriels.';
$lesson->type = 'Mathématiques';

LessonController::AddLesson($lesson);

*/

/*

$coursProg = LessonController::GetAllLessonsOfType('Programmation');

echo "<h1>Programmation</h1>";

foreach($coursProg as $cours)
{
    echo "<h2>$cours->titre</h2>";
    echo "<h3>$cours->description</h3>";
    echo "<a href='$cours->chemin'>Accéder au cours.</a>";
}

*/

/*

$qcm = new QCM();
$qcm->header = new QCMHeader();
$qcm->header->id = 'CPlusPlus';
$qcm->header->type = 'Programmation';

    $q = new Question();
    $q->label = "En C++, quel mot clé est utilisé pour assigner à un pointeur une adresse invalide ?";

        $a = new Answer();
        $a->label = 'nullptr';
        $a->isCorrect = true;
        array_push($q->answers, $a);
        $a = new Answer();
        $a->label = 'NULL';
        $a->isCorrect = false;
        array_push($q->answers, $a);
        $a = new Answer();
        $a->label = '0';
        $a->isCorrect = false;
        array_push($q->answers, $a);
        $a = new Answer();
        $a->label = 'N\'importe quelle valeur.';
        $a->isCorrect = false;
        array_push($q->answers, $a);

    array_push($qcm->questions, $q);

    $q = new Question();
    $q->label = "En C++, quelles sont les syntaxes <u>incorrectes</u> ?";

        $a = new Answer();
        $a->label = 'std::vector<int> var = {1, 2, 3, 4};';
        $a->isCorrect = false;
        array_push($q->answers, $a);
        $a = new Answer();
        $a->label = 'std::vector(int) var = {1, 2, 3, 4};';
        $a->isCorrect = true;
        array_push($q->answers, $a);
        $a = new Answer();
        $a->label = 'std::vector<int> var = 3;';
        $a->isCorrect = true;
        array_push($q->answers, $a);
        $a = new Answer();
        $a->label = 'std::vector<int> var(3);';
        $a->isCorrect = false;
        array_push($q->answers, $a);

    array_push($qcm->questions, $q);


QCMController::AddQCM($qcm);

*/

//echo '<p>' . (QCMController::IsQCMIdAvailable('CPlusPlus') ? 'dispo' : ' pas dispo') . '</p>';

/*

$headers = QCMController::GetAllQCMHeaders();

echo "<h1>Liste des QCM disponibles</h1>";

foreach($headers as $h)
{
    echo "<h2>$h->id</h2>";
    echo "<p>Type : $h->type</p>";

    $qcmDetaille = QCMController::GetQCMById($h->id);

    foreach($qcmDetaille->questions as $question)
    {
        echo "<p>Question: $question->label</p>";

        foreach($question->answers as $answer)
        {
            echo "<p style='color:" . ($answer->isCorrect ? 'green' : 'red') . ";'>";
            echo "$answer->label";
            echo "</p>";
        }
    }
}

*/

//QCMController::RemoveQCMById('CPlusPlus');

//ForumController::AddTopic(Session::GetLogin(), "Besoin d'aide sur les pointeurs...", "Bonjour, j'ai besoin d'aide, je comprends pas les pointeurs. On dit par exemple int* i = nullptr;, dans le cours il est dit que int* est une adresse, mais je ne comprends pas, car float* serait une adresse aussi, mais, ce ne sont pas des int et des floats en même temps...?<br>Help!");



echo "<h1>Forum</h1>";

$topicHeaders = ForumController::GetAllTopicHeaders();

foreach($topicHeaders as $topicHeader)
{
    echo "<p><a href='topic.php?id=$topicHeader->id'>$topicHeader->title</a>, par $topicHeader->creator, $topicHeader->answersNumber réponses.</p>";
}



?>