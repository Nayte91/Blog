<?php

namespace P5blog\models;

final class Post extends AbstractEntity
{
    public int $id;
    public string $author;
    public string $title;
    public string $heading;
    public string $content;
    public \DateTime $modificationdate;
    public int $userid;

    public static function retrieveLatest(?int $number = 0): ?array
    {
        $db = self::dbconnect();

        if ($number == 0){
            $query = $db->prepare("SELECT post.id, post.title, post.modification_date AS modificationdate, post.heading, post.content, user.name as author, user.id AS userid FROM post LEFT JOIN user ON post.author = user.id ORDER BY modification_date DESC");
        } else {
            $query = $db->prepare("SELECT post.id, post.title, post.modification_date AS modificationdate, post.heading, post.content, user.name as author, user.id AS userid FROM post LEFT JOIN user ON post.author = user.id ORDER BY modification_date DESC LIMIT :number");
            $query->bindParam(':number', $number, \PDO::PARAM_INT);
        }

        $query->execute();
        $response = $query->fetchAll(\PDO::FETCH_ASSOC);
        unset($db);

        return $response;
    }

    public static function createOne(array $data): bool
    {
        $post = new self($data);

        $db = self::dbconnect();
        $query = $db->prepare('INSERT INTO post (modification_date, author, title, heading, content) VALUES (NOW(), :author, :title, :heading, :content)');
        $query->bindValue(':author', $post->author, \PDO::PARAM_INT);
        $query->bindValue(':title', $post->title, \PDO::PARAM_STR);
        $query->bindValue(':heading', $post->heading, \PDO::PARAM_STR);
        $query->bindValue(':content', $post->content, \PDO::PARAM_STR);

        return $query->execute();
    }

    public static function readOne(int $id): self
    {
        $post = new self(['id' => $id]);

        $db = self::dbconnect();
        $req = $db->prepare('SELECT post.id, title, heading, content, modification_date AS modificationdate, user.name as author FROM post LEFT JOIN user ON post.author = user.id WHERE post.id = :number');
        $req->bindParam(':number', $id, \PDO::PARAM_INT);
        $req->execute();
        $response = $req->fetch();

        if (!$response) {
            throw new \Exception("Impossible de récupérer le billet");
        }

        $post->hydrate($response);

        return $post;
    }

    public static function updateOne(array $data): bool
    {
        $post = new self($data);

        $db = self::dbconnect();
        $query = $db->prepare('UPDATE post SET title=?, heading=?, content=? WHERE id=?');

        return $query->execute([$post->title, $post->heading, $post->content, $post->id ]);
    }

    public static function deleteOne(int $id): bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('DELETE FROM post WHERE id = :id');
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        return $query->execute();
    }
}
