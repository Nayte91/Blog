<?php

namespace P5blog\models;

final class PostManager
{
    use DBConnector;

    public function getOne($postId)
    {
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function newOne($author, $content)
    {
        $posts = $this->db->prepare('INSERT INTO post(author, content, creation_date) VALUES(?, ?, NOW())');
        $affectedLines = $posts->execute(array($author, $content));

        return $affectedLines;
    }

    public function deleteOne($postId)
    {

    }

    public function getLatest($object, ?int $number = 0): array
    {
        if ($number == NULL){
            $number = 0;
        }


        $statement = $this->db->prepare("SELECT id, creation_date, title, chapo, content, author FROM ? LIMIT ? ORDER BY creation_date");
        $statement->execute($object, $number);
        $posts[] = new Post($statement->fetchAll());

        //un peu de sécurité autour de $data

        return $posts;
    }
}
