<?php

require_once 'Lesson.php';
require_once '/app/controllers/Sessions.php';
require_once '/app/controllers/ViewLauncher.php';

if(isset($_POST['whatToDo']))
{
    switch($_POST['whatToDo'])
    {
        case 'AddLesson':
            if(!isset($_POST['lesson']))
                throw new Exception('Impossible d\'ajouter une lesson : paramètre POST "lesson" inexistant.');
            Lessons::AddLEsson($_POST['lesson']);
            break;
        default:
            break;
    }
}

class Lessons
{
    /*
        Ajouter un cours.
        $lesson : instance de la classe Lesson contenant les informations nécessaires à la création du cours.
    */
    public static function AddLesson($lesson)
    {
        //On verifie si la session existe et si l'utilisateur est admin 
        if(Session::Exists() && Session::IsAdmin())
        {
            $coursInstance = new Cours();

            if(!$coursInstance->ajoutCours($lesson->titre, $lesson->description, $lesson->type, $lesson->chemin)) throw new Exception('Impossible d\'ajouter le cours à la base de données');
        }
        else throw new Exception('Aucune session en cours ou utilisateur non admin'); 
       
        ViewLauncher::LessonAdded();
    }

    /*
        Retourne tous les cours du type passé en paramètre.
        $type : type des cours à retourner.
    */
    public static function GetAllLessonsOfType($type)
    {
        $coursInstance = new Cours();

        //On récupère les cours tels qu'ils sont dans la bdd
        $rawLessons = $coursInstance->getCoursByType($type);

        $out = array();

        //Pour chaque cours, on créé une instance de Lesson que l'on ajoute à un tableau.
        foreach($rawLessons as $rawLesson){
            $lesson = new Lesson;
            $lesson->idCours = $rawLesson['idCours'];
            $lesson->titre = $rawLesson['titre'];
            $lesson->description = $rawLesson['description'];
            $lesson->type = $rawLesson['type'];
            $lesson->chemin = $rawLesson['chemin'];
            $lesson->dateCours = $rawLesson['dateCours'];

            array_push($out, $lesson);
        }

        return $out;
    }
}

?>