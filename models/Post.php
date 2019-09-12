<?php

namespace P5blog\models;

class Post
{
    use Hydrator;

    private $id;
    private $chapo;
    private $title;
    private $content;
    private $creationDate;

    public function __construct($table)
    {
        $this->hydrate($table);
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}