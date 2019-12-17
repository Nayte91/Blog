<?php

namespace P5blog\models;

final class Post extends AbstractEntity
{
    public int $id;
    public string $creationdate;
    public string $author;
    public string $title;
    public string $heading;
    public string $content;

    public static function retrieveFromId(int $id): self
    {
        $post = new self(['id' => $id]);

        $db = self::dbconnect();
        $req = $db->prepare('SELECT post.id, title, heading, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creationdate, user.name as author FROM post LEFT JOIN user ON post.author = user.id WHERE post.id = :number');
        $req->bindParam(':number', $id, \PDO::PARAM_INT);
        $req->execute();
        $response = $req->fetch();

        if (!$response)
            throw new \Exception("Impossible de récupérer le billet");

        $post->hydrate($response);

        return $post;
    }

    public static function retrieveFromAuthor(int $author, ?int $number = 0): ?array {}

    public static function retrieveLatest(?int $number = 0): ?array
    {
        $db = self::dbconnect();

        if ($number == 0){
            $query = $db->prepare("SELECT post.id, post.title, DATE_FORMAT(post.creation_date, \"%W, %e %M %Y\") as date, post.heading, post.content, user.name FROM post LEFT JOIN user ON post.author = user.id ORDER BY creation_date DESC");
        } else {
            $query = $db->prepare("SELECT post.id, post.title, DATE_FORMAT(post.creation_date, \"%W, %e %M %Y\") as date, post.heading, post.content, user.name FROM post LEFT JOIN user ON post.author = user.id ORDER BY creation_date DESC LIMIT :number");
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
        $query = $db->prepare('INSERT INTO post (creation_date, author, title, heading, content) VALUES (NOW(), :author, :title, :heading, :content)');
        $query->bindValue(':author', $post->author, \PDO::PARAM_INT);
        $query->bindValue(':title', $post->title, \PDO::PARAM_STR);
        $query->bindValue(':heading', $post->heading, \PDO::PARAM_STR);
        $query->bindValue(':content', $post->content, \PDO::PARAM_STR);

        return $query->execute();
    }

    public static function deleteFromId(int $id): bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('DELETE FROM post WHERE id = :id');
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        return $query->execute();
    }

    public function setId(int $id): void
    {
        $this->id = (int)$id;
    }

    public function setCreationdate(string $creationdate): void
    {
        $this->creationdate = $creationdate;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setHeading(string $heading): void
    {
        $this->heading = $heading;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
