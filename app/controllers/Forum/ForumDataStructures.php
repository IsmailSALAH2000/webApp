<?php

class Message
{
    public int $id = -1;
    public int $idTopic = -1;
    public string $author = '';
    public string $content = '';
    public string $date = '';
}

class TopicHeader
{
    public int $id = -1;
    public string $title = '';
    public string $creator = '';
    public int $answersNumber = 0;
}

class Topic
{
    public TopicHeader $header;
    public array $messages = array();

    function __construct()
    {
        $this->header = new TopicHeader();
    }
}

?>