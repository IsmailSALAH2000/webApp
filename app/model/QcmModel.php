<?php
class QcmModel {
  use Model;
  private $xml_file;
  
  public function __construct($xml_file) {
    $this->xml_file = $xml_file;
  }

  public function getQuestions() {
    $questions = array();
    $xml = simplexml_load_file($this->xml_file);
    foreach ($xml->question as $question) {
      $question_text = (string)$question->text;
      $choices = array();
      foreach ($question->choices->choice as $choice) {
        $choice_text = (string)$choice;
        $is_correct = (string)$choice['correct'];
        $choices[] = array('text' => $choice_text, 'correct' => $is_correct);
      }
      $questions[] = array('text' => $question_text, 'choices' => $choices);
    }
    return $questions;
  }
}
?>
