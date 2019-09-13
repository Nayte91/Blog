<?php

namespace P5blog\models;

final class Comment extends AbstractEntity
{
    private $author;
    private $content;

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
