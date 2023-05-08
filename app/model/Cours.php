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

    //retourne tous les cours de la base, 0 s'il n'en existe pas
    public function getAllCours() {
        $cours = $this->findAll();
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

    //retourne une liste de tous les types de cours existants, 0 si aucun cours n'existe
    public function getAllTypes() {
        $cours = $this->findAll();
        if($cours) {
            $listeTypes = array();
            foreach($cours as $c) {
                $listeTypes[] = $c['type'];
            }
            return array_unique($listeTypes, SORT_STRING | SORT_FLAG_CASE);
        }
        return 0;
    }

    //retourne le chemin du cours d'id $id, 0 s'il n'existe pas
    public function getCheminCours($id) {
        $data['idCours'] = $id;
        $cours = $this->select($data);
        if($cours) {
            return $cours['chemin'];
        }
        return 0;
    }

    //ajoute un cours à la base de donnée, retourne 1 si l'ajout est effectué, 0 sinon
    public function ajoutCours($titre, $description, $type, $fichier) {
        $data['titre'] = $titre;
        $data['description'] = $description;
        $data['type'] = $type;
        $data['chemin'] = '../../../model/cours/'.$fichier['name'];

        $nomFichier = basename($fichier['name']);
        $cheminFichier = __DIR__ .'/cours/' . $nomFichier;
        if(!file_exists($cheminFichier)) {
            if(move_uploaded_file($fichier['tmp_name'], $cheminFichier)) {
                if(is_array($this->insert($data))) {
                    return 1;
                }
            }
        }
        return 0;
    }

    //ajoute le cours d'id $id de la base de donnée, retourne 1 si la suppression est effectuée, 0 sinon
    public function supprimerCours($id) {
        $chemin = $this->getCheminCours($id);
        $fichier = __DIR__.'/'.substr($chemin, strlen('../../../model/'));
        if(file_exists($fichier)) {
            unlink($fichier);
            if(is_array($this->delete($id, 'idCours'))) {
                return 1;
            }
        }
        return 0;
    }

}
