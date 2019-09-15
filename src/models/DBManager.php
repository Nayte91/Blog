<?php

namespace P5blog\models;

class DBManager
{
    use DBConnector;

    private $db;

    public function __construct()
    {
        return $this->db = $this->connection();
    }

    public function getAllPost()
    {

    }

    public function getOnePost($postId)
    {
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        $data[] = new Post($comments);

        return $data;
    }

    public function newPost($author, $content)
    {
        $posts = $this->db->prepare('INSERT INTO post(author, content, creation_date) VALUES(?, ?, NOW())');
        $affectedLines = $posts->execute(array($author, $content));

        return $affectedLines;
    }

    public function newComment($author, $comment)
    {
        $comments = $this->db->prepare('INSERT INTO comment(author, content, creation_date) VALUES(?, ?, NOW())');
        $affectedLines = $comments->execute(array($author, $comment));

        return $affectedLines;
    }

    public function newUser($name , $email, $password, $admin)
    {
        $user = $this->db->prepare('INSERT INTO user(name, email, password, creation_date, admin) VALUES(?,?,?, NOW(), ?)');
        $result = $user->execute(array($name , $email, $password, $admin));

        return $result;
    }

    public function getLatest($object, ?int $number = 0): array
    {
        if $number == NULL
            $number = 0;

        $statement = $this->db->prepare("SELECT id, creation_date, title, chapo, content, author FROM ? LIMIT ? ORDER BY creation_date");
        $statement->execute($object, $number);
        $tableau = $statement->fetchAll();

        $data[] = new $object($tableau);

        return $data;
    }
}
