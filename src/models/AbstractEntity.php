<?php

namespace P5blog\models;

abstract class AbstractEntity
{

    public function __construct($table)
    {
        $this->hydrate($table);
    }

    public function hydrate(array $table): void
    {
        foreach ($table as $column => $value)
        {
            $method = "set".ucfirst($column);
            if (method_exists($this, $method))
                $this->$method($value);
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
