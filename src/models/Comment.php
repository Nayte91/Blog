<?php

namespace P5blog\models;

final class Comment extends AbstractEntity
{
    private int $id;
    private string $author;
    private string $content;
    private string $creationdate;

    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public static function createOne(array $data): bool
    {
        $comment = new self($data);

        $db = self::dbconnect();
        $query = $db->prepare('INSERT INTO post (creation_date, author, content) VALUES (NOW(), :author, :content)');
        $query->bindValue(':author', $comment->author, \PDO::PARAM_INT);
        $query->bindValue(':content', $comment->content, \PDO::PARAM_STR);

        return $query->execute();
    }

    public static function updateOne(array $data): bool
    {
        $comment = new self($data);

        $db = self::dbconnect();
        $query = $db->prepare('UPDATE comment SET content=? WHERE id=?');

        return $query->execute([$comment->content, $comment->id]);
    }
}
