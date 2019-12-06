<?php

namespace P5blog\models;

final class Post extends AbstractEntity
{
    private $id;
    private $creationdate;
    private $author;
    private $title;
    private $heading;
    private $content;

    public static function retrieveFromId(int $id): ?self
    {
        $db = self::dbconnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public static function retrieveFromAuthor(int $author): ?array
    {

    }

    public static function retrieveLatest(?int $number = 0): ?array
    {
        $db = self::dbconnect();
        if ($number == 0){
            $query = $db->prepare("SELECT post.title, DATE_FORMAT(post.creation_date, \"%W, %e %M %Y\") as date, post.chapo, post.content, user.name FROM post LEFT JOIN user ON post.author = user.id ORDER BY creation_date DESC");
        } else {
            $query = $db->prepare("SELECT post.title, DATE_FORMAT(post.creation_date, \"%W, %e %M %Y\") as date, post.chapo, post.content, user.name FROM post LEFT JOIN user ON post.author = user.id ORDER BY creation_date DESC LIMIT :number");
            $query->bindParam(':number', $number, \PDO::PARAM_INT);
        }
        $query->execute();
        $response = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    public static function createOne(array $data): bool
    {
        $post = new self($data);

        $db = self::dbconnect();
        $query = $db->prepare('INSERT INTO post (creationdate, author, title, heading, content) VALUES (NOW(), :author, :title, :heading, :content)');
        $query->bindValue(':author', $post->author, \PDO::PARAM_INT);
        $query->bindValue(':name', $post->title, \PDO::PARAM_STR);
        $query->bindValue(':password', $post->heading, \PDO::PARAM_STR);
        $query->bindValue(':email', $post->content, \PDO::PARAM_STR);

        return $query->execute();
    }

    public static function deleteFromId(int $id): ?bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('DELETE FROM post WHERE id = :id');
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        return $query->execute();
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

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
