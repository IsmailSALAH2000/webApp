<?php

require_once __DIR__ . '/Lesson.php';
require_once __DIR__ . '/../Users/Sessions.php';
require_once __DIR__ . '/../ViewLauncher.php';
require_once __DIR__ . '/../../model/Cours.php';


/*
    Au chargement de la page, on va appeler les fonctions demandées dans la variable POST 'whatToDo', qui représentent des endpoints pour cette page. C'est-à-dire que peu importe le résultat de ces fonctions, une vue sera chargée à leur issue.

    Utilisation : passer les paramètres en POST.
    'whatToDo' correspond à :
        - 'addLesson' pour ajouter un cours. Paramètres supplémentaires obligatoires :
            - 'title', titre du cours.
            - 'description', description du cours.
            - 'type', type du cours.
            - 'file', chemin d'accès au cours.
        - 'removeLesson' pour supprimer un cours. Paramètres supplémentaires obligatoires :
            - 'lessonId', correspond à l'id du cours à supprimer.
*/

if(isset($_POST['whatToDo']))
{
    switch($_POST['whatToDo'])
    {
        case 'addLesson':
            if(!isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['type']) || !isset($_FILES['file']))
                throw new Exception('Impossible d\'ajouter une lesson : paramètre POST ou FILES manquant.');
            LessonController::AddLesson($_POST['title'], $_POST['description'], $_POST['type'], $_FILES['file']);
            break;
        case 'removeLesson' :
            if(!isset($_POST['lessonId']))
                throw new Exception('Impossible de supprimer une lesson : paramètre POST "lessonId" inexistant.');
            LessonController::RemoveLessonById($_POST['lessonId']);
        default:
            break;
    }
}

class LessonController
{
    /*
        Ajouter un cours.
        $lesson : instance de la classe Lesson contenant les informations nécessaires à la création du cours.
    */
    /*
    public static function AddLesson(Lesson $lesson)
    {
        //On verifie si la session existe et si l'utilisateur est admin 
        if(Session::Exists() && Session::IsAdmin())
        {
            $coursInstance = new Cours();

            if(!$coursInstance->ajoutCours($lesson->titre, $lesson->description, $lesson->type, $lesson->chemin)) throw new Exception('Impossible d\'ajouter le cours à la base de données');
        }
        else throw new Exception('Aucune session en cours ou utilisateur non admin'); 
       
        ViewLauncher::LessonAdded();
    }*/

    /*
        Ajouter un cours.
        $title : titre du cours.
        $description : description du cours.
        $type : type du cours.
        $file : chemin d'accès au cours.
    */
    public static function AddLesson($title, $description, $type, $file)
    {
        //On verifie si la session existe et si l'utilisateur est admin 
        if(Session::Exists() && Session::IsAdmin())
        {
            if ($file['error'] === UPLOAD_ERR_OK) { //Vérification du téléchargement
                $fileName = basename($file['name']);
                $extension = substr($fileName, -4);
                if($extension == ".mp4" || $extension == ".pdf") { //Vérification du format
                    $coursInstance = new Cours();
                    if(!$coursInstance->ajoutCours($title, $description, $type, $file)) ViewLauncher::LessonAddedError("Nom de fichier déjà existant");
                    else ViewLauncher::LessonAdded();
                }
                else ViewLauncher::LessonAddedError("Mauvais format");
            }
            else throw new Exception('Erreur lors du téléchargement du fichier');
        }
        else throw new Exception('Aucune session en cours ou utilisateur non admin'); 
    }

    /*
        Supprime un cours du serveur selon son id;
    */
    public static function RemoveLessonById(int $id)
    {
        $coursInstance = new Cours();
        $coursInstance->supprimerCours($id);

        ViewLauncher::LessonRemoved();
    }

    /*
     * Retourne tous les cours disponibles.
     */
    public static function GetAllLessons() : array
    {
        $coursInstance = new Cours();

        //On récupère les cours tels qu'ils sont dans la bdd
        $rawLessons = $coursInstance->getAllCours();

        $out = array();

        //Pour chaque cours, on créé une instance de Lesson que l'on ajoute à un tableau.
        if($rawLessons)
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
        $type : type des cours à retourner.
    */
    /**
     * Retourne tous les cours d'un type donné.
     *
     * @param string $type Le type de cours (par exemple, 'Programmation').
     * @return array
     */
    public static function GetAllLessonsOfType(string $type) : array
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
        Retourne un tableau contenant un cours selon son ID ainsi que son format (.mp4, .pdf ou .pptx). Retourne null en cas d'id introuvable.
    */
    public static function GetLessonById(int $id) : array
    {
        $coursInstance = new Cours();
        $rawLesson = $coursInstance->getCours($id); // Récupération le cours depuis le modèle sous forme brute.

        if($rawLesson == null) return null;

        $lesson = new Lesson(); // On crée une instance de la classe Lesson, permettant une manipulation plus aisée de l'information.
        $lesson->idCours = $rawLesson['idCours'];
        $lesson->titre = $rawLesson['titre'];
        $lesson->description = $rawLesson['description'];
        $lesson->type = $rawLesson['type'];
        $lesson->chemin = $rawLesson['chemin'];
        $lesson->dateCours = $rawLesson['dateCours'];

        // Recherche du format utilisé pour ce cours.
        $extension = substr($lesson->chemin, -4);
        if($extension == ".mp4") { // format mp4
            $format = ".mp4";
        }
        else {
            if($extension == ".pdf") { // format pdf
                $format = ".pdf";
            }
        }

        $LessonWithFormat = array(
            "format" => $format,
            "cours" => $lesson
        );

        return $LessonWithFormat;
    }

    /*
        Retourne tous les types de cours existants.
    */
    public static function GetAllTypes()
    {
        $coursInstance = new Cours();
        return $coursInstance->getAllTypes();
    }

}

?>