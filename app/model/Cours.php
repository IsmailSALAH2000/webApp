<?php

class Cours {
    use Model;
    protected $table = "Cours";

    public function getCours($id) {
        $data['idCours'] = $id;
        $cours = $this->select($data);
        if($cours) {
            return $cours;
        }
        return 0;
    }

    public function ajoutCours($id, $titre, $description, $type, $chemin) {
        $data['idCours'] = $id;
        $data['titre'] = $titre;
        $data['description'] = $description;
        $data['type'] = $type;
        $data['chemin'] = $chemin;
        if(is_array($this->insert($data))) {
            return 1;
        }
        return 0;
    }

    public function supprimerCours($id) {
        if(is_array($this->delete($id, 'idCours'))) {
            return 1;
        }
        return 0;//erreur
    }

}
