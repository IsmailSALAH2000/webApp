<?php

class QCMHeader
{
    public $id = '';
    public $type = '';
}

class Answer
{
    public $label = '';
    public $isCorrect = false;
}

class Question
{
    public $label = '';
    public $answers = array(); 
}

class QCM
{
    public $header = new QCMHeader();
    public $questions = array();
}

?>