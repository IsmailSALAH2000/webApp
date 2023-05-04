<?php

require_once 'Lesson.php'
require_once '/app/controllers/Sessions.php'
require '/app/controllers/ViewsLauncher.php'


/*
    Au chargement de la page, on va appeler les fonctions demandées dans la variable POST 'whatToDo', qui représentent des endpoints pour cette page. C'est-à-dire que peu importe le résultat de ces fonctions, une vue sera chargée à leur issue.

    Utilisation : passer les paramètres en POST.
    'whatToDo' correspond à :
        - 'addLesson' pour ajouter un cours. Paramètres supplémentaires obligatoires :
            - 'lesson', correspond à une instance de la classe cours.
        - 'removeLesson' pour supprimer un cours. Paramètres supplémentaires obligatoires :
            - 'lessonId', correspond à l'id du cours à supprimer.
*/

if(isset($_POST['whatToDo']))
{
    switch($_POST['whatToDo'])
    {
        case 'addLesson':
            if(!isset($_POST['lesson']))
                throw new Exception('Impossible d\'ajouter une lesson : paramètre POST "lesson" inexistant.');
            Lessons::AddLEsson($_POST['lesson']);
            break;
        case 'removeLesson' :
            if(!isset($_POST['lessonId']))
                throw new Exception('Impossible de supprimer une lesson : paramètre POST "lessonId" inexistant.');
            Lessons::RemoveLessonById($_POST['lessonId']);
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
    public static AddLesson($lesson)
    {
        //On verifie si la session existe et si l'utilisateur est admin 
        if(Session::Exists() && Session::IsAdmin())
        {
            $coursInstance = new Cours();

            if(!$coursInstance->ajoutCours($lesson->titre, $lesson->description, $lesson->type, $lesson->chemin)) throw new Exception('Impossible d\'ajouter le cours à la base de données');
        }
        else throw new Exception('Aucune session en cours ou utilisateur non admin'); 
       
        ViewsLauncher::LessonAdded();
    }

    /*
        Supprime un cours du serveur selon son id;
    */
    public static function RemoveLessonById($id)
    {
        $coursInstance = new Cours();
        $coursInstance->supprimerCours($id);

        ViewsLauncher::LessonRemoved();
    }

    /*
        Retourne tous les cours du type passé en paramètre.
        $type : type des cours à retourner.
    */
    public static GetAllLessonsOfType($type)
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

    /*
        Retourne un cours selon son ID. Retourne null en cas d'id introuvable.
    */
    public static function GetLessonById($id)
    {
        $coursInstance = new Cours();
        $rawLessons = $coursInstance->getCours($id); // Récupération le cours depuis le modèle sous forme brute.

        if($rawLessons == null) return null;

        $lesson = new Lesson(); // On crée une instance de la classe Lesson, permettant une manipulation plus aisée de l'information.
        $lesson->idCours = $rawLesson['idCours'];
        $lesson->titre = $rawLesson['titre'];
        $lesson->description = $rawLesson['description'];
        $lesson->type = $rawLesson['type'];
        $lesson->chemin = $rawLesson['chemin'];
        $lesson->dateCours = $rawLesson['dateCours'];

        return $lesosn;
    }

}

?>