<?php

require_once __DIR__ . '/Model.php';

class Cours {
    use Model;
    protected $table = "Cours";

    //retourne le cours d'id $id, 0 s'il n'existe pas
    public function getCours($id) {
        $data['idCours'] = $id;
        $cours = $this->select($data);
        if($cours) {
            return $cours;
        }
        return 0;
    }

    //retourne tous les cours de type $type, 0 s'il n'en existe pas
    public function getCoursByType($type) {
        $data['type'] = $type;
        $cours = $this->selectAll($data);
        if($cours) {
            return $cours;
        }
        return 0;
    }

    //ajoute un cours à la base de donnée, retourne 1 si l'ajout est effectué, 0 sinon
    public function ajoutCours($titre, $description, $type, $chemin) {
        $data['titre'] = $titre;
        $data['description'] = $description;
        $data['type'] = $type;
        $data['chemin'] = $chemin;
        if(is_array($this->insert($data))) {
            return 1;
        }
        return 0;
    }

    //ajoute le cours d'id $id de la base de donnée, retourne 1 si la suppression est effectuée, 0 sinon
    public function supprimerCours($id) {
        if(is_array($this->delete($id, 'idCours'))) {
            return 1;
        }
        return 0;
    }

}
