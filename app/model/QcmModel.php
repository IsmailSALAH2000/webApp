<?php
require_once 'Model.php';
class QcmModel {
  use Model;

  //retourne le qcm de nom $id ou null si il n'existe pas
  public function getQCM($id) {
    if($this->QCMExiste($id)) {
      $xml = simplexml_load_file(__DIR__ . '/qcm/'.$id.'.xml');
      $questions = array();
      foreach ($xml->question as $question) {
        $question_text = (string)$question->text;
        $choices = array();
        foreach ($question->choice as $choice) {
          $choice_text = (string)$choice;
          $is_correct = (string)$choice['correct'];
          $choices[] = array('text' => $choice_text, 'correct' => $is_correct);
        }
        $questions[] = array('text' => $question_text, 'choices' => $choices);
      }
      return array('type' => $xml->type, 'questions' => $questions);
    }
    return null;
  }

  //retourne le type du qcm de nom $id ou null si il n'existe pas
  public function getTypeQCM($id) {
    if($this->QCMExiste($id)) {
      $xml = simplexml_load_file(__DIR__ . '/qcm/'.$id.'.xml');
      return $xml->type;
    }
    return null;
  }

  //retourne une liste contenant le nom de tous les qcm disponibles
  public function getAllQCM() {
    $listeFichiers = scandir(__DIR__ . '/qcm');
    $listeQCM = array();
    foreach($listeFichiers as $nomFichier) {
      $taille = strlen($nomFichier);
      if($taille>4) { //évite de retourner . et ..
        $nomQCM = substr($nomFichier, 0, $taille-4);
        $listeQCM[] = $nomQCM;
      }
    }
    return $listeQCM;
  }

  //ajoute le qcm avec pour nom $id et comme données celles contenues dans $data
  //retourne 0 si l'ajout s'est bien passé, 1 sinon
  //data est du type ('type' => val, 'questions' => array('text' => val, 'choices' => array('text' => val, 'correct' => val)))
  public function ajoutQCM($id, $data) {
    if(!$this->QCMExiste($id)) {
      $dom = new DOMDocument('1.0', 'UTF-8');
      $qcm = $dom->createElement('qcm');
      $type = $dom->createElement('type', $data['type']);
      $qcm->appendChild($type);

      foreach($data['questions'] as $question) {
        $question_xml = $dom->createElement('question');
        $text = $dom->createElement('text', $question['text']);
        $question_xml->appendChild($text);

        foreach($question['choices'] as $choice) {
          $choice_xml = $dom->createElement('choice', $choice['text']);
          $correct = $dom->createAttribute('correct');
          $correct->value = $choice['correct'];
          $choice_xml->appendChild($correct);
          $question_xml->appendChild($choice_xml);
        }
        $qcm->appendChild($question_xml);
      }

      $dom->appendChild($qcm);
      $dom->formatOutput = true;
      $dom->save(__DIR__ . '/qcm/'.$id.'.xml');//verif que le fichier n'existe pas déjà
      return 0;
    }
    return 1;
  }

  //supprime le qcm de nom $id
  //retourne 0 si la suppression s'est bien passé, 1 sinon
  public function supprimeQCM($id) {
    if($this->QCMExiste($id)) {
      unlink(__DIR__ . '/qcm/'.$id.'.xml');
      return 0;
    }
    return 1;
  }

  //retourne 1 si le qcm existe, 0 sinon
  public function QCMExiste($id) { 
    $listeQCM = scandir(__DIR__ . '/qcm');
    foreach($listeQCM as $nomQCM) {
      if(strcmp($nomQCM, $id.'.xml') == 0) {
        return 1;
      }
    }
    return 0;
  }

  

}
?>
