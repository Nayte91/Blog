<?php

namespace P5blog\models;

final class Post extends AbstractEntity
{
    private $author;
    private $title;
    private $heading;
    private $content;

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
