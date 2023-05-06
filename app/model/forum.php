<?php

require_once __DIR__ . '/Database.php';

class Forum {

    use Database;

    private $bdd;
    private $q_listeTopics;
    private $q_listeMessages;
    private $q_ajoutMessage;
    private $q_getNbReponses;
    private $q_incrementationNbReponses;
    private $q_ajoutTopic;
    private $q_dernierIdTopic;
    private $q_supprimeMessage;
    private $q_supprimeTopic;
    private $q_supprimeMessagesTopic;
    private $q_getTopic;

    public function __construct() {
        //require_once('connexion.php');
        $this->bdd = $this->connect();

        $this->q_listeTopics = $this->bdd->prepare('SELECT * FROM Topic;');
        $this->q_listeMessages = $this->bdd->prepare('SELECT * FROM `Message` WHERE idTopic=:i;');
        $this->q_ajoutMessage = $this->bdd->prepare('INSERT INTO `Message` (idTopic, idUtilisateur, contenu) VALUES (:idT,:idU,:c)');
        $this->q_getNbReponses = $this->bdd->prepare('SELECT nbReponses FROM Topic WHERE idTopic=:i;');
        $this->q_incrementationNbReponses = $this->bdd->prepare('UPDATE Topic SET nbReponses=:n WHERE idTopic=:i');
        $this->q_ajoutTopic = $this->bdd->prepare('INSERT INTO Topic (titre, idUtilisateur) VALUES (:t,:i)');
        $this->q_dernierIdTopic = $this->bdd->prepare('SELECT MAX(idTopic) FROM Topic;');
        $this->q_supprimeMessage = $this->bdd->prepare('DELETE FROM `Message` WHERE idMessage=:i;');
        $this->q_supprimeTopic = $this->bdd->prepare('DELETE FROM Topic WHERE idTopic=:i;');
        $this->q_supprimeMessagesTopic = $this->bdd->prepare('DELETE FROM `Message` WHERE idTopic=:i;');
        $this->q_getTopic = $this->bdd->prepare('SELECT * FROM Topic WHERE idTopic=:i;');
    }

    public function getAllTopics() {
        $this->q_listeTopics->execute();
        return $this->q_listeTopics->fetchAll();
    }

    public function getTopic($id) {
        $this->q_getTopic->bindValue('i', $id, PDO::PARAM_INT);
        $this->q_getTopic->execute();
        return $this->q_getTopic->fetchAll()[0];
    }

    public function getAllMessages(int $idTopic) {
        $this->q_listeMessages->bindValue('i', $idTopic, PDO::PARAM_INT);
        $this->q_listeMessages->execute();
        return $this->q_listeMessages->fetchAll();
    }

    public function ajoutMessage(int $idTopic, string $idUtilisateur, string $contenu) {
        $this->q_ajoutMessage->bindValue('idT', $idTopic, PDO::PARAM_INT);
        $this->q_ajoutMessage->bindValue('idU', $idUtilisateur, PDO::PARAM_STR);
        $this->q_ajoutMessage->bindValue('c', $contenu, PDO::PARAM_STR);
        $this->q_ajoutMessage->execute();

        //modification de la valeur de nbReponses dans la table
        $this->q_getNbReponses->bindValue('i', $idTopic, PDO::PARAM_INT);
        $this->q_getNbReponses->execute();
        $res = $this->q_getNbReponses->fetchAll();
        $nbReponse = $res[0]['nbReponses']+1;
        $this->q_incrementationNbReponses->bindValue('i', $idTopic, PDO::PARAM_INT);
        $this->q_incrementationNbReponses->bindValue('n', $nbReponse, PDO::PARAM_INT);
        $this->q_incrementationNbReponses->execute();

    }

    public function ajoutTopic(string $titre, string $idUtilisateur, string $contenu) {
        //création topic
        $this->q_ajoutTopic->bindValue('t', $titre, PDO::PARAM_STR);
        $this->q_ajoutTopic->bindValue('i', $idUtilisateur, PDO::PARAM_STR);
        $this->q_ajoutTopic->execute();

        //création permier message
        $this->q_dernierIdTopic->execute(); //peut poser un problème de concurrence si grand nombre créations en même temps -> très peu probable ici
        $res = $this->q_dernierIdTopic->fetchAll();
        $idTopic = $res[0]['MAX(idTopic)'];
        $this->ajoutMessage($idTopic, $idUtilisateur, $contenu);
        return $idTopic;
    }

    public function supprimeMessage(int $idMessage) {
        $this->q_supprimeMessage->bindValue('i', $idMessage, PDO::PARAM_INT);
        $this->q_supprimeMessage->execute();
    }

    public function supprimeTopic(int $idTopic) {
        $this->q_supprimeTopic->bindValue('i', $idTopic, PDO::PARAM_INT);
        $this->q_supprimeTopic->execute();
        //pb avec wampserver : le ON DELETE CASCADE ne marche pas
        $this->q_supprimeMessagesTopic->bindValue('i', $idTopic, PDO::PARAM_INT);
        $this->q_supprimeMessagesTopic->execute();
    }
}

?>