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
    public $header;
    public $questions = array();

    function __construct()
    {
        $this->header = new QCMHeader();
    }
}

?>