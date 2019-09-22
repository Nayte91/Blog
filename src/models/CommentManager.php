<?php

namespace P5blog\models;

final class CommentManager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        $data[] = new Comment($comments);

        return $data;
    }

    public function newComment($author, $comment)
    {
        $comments = $this->db->prepare('INSERT INTO comment(author, content, creation_date) VALUES(?, ?, NOW())');
        $affectedLines = $comments->execute(array($author, $comment));

        return $affectedLines;
    }
}