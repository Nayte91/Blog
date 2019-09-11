<?php

namespace P5blog\models;

class DBManager
{
    private $db;

    public function __construct(){
        try
        {
            return $this->db = new \PDO('mysql:host=localhost;dbname=p5blog;charset=utf8', 'root', '');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
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
}