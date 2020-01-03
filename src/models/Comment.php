<?php

namespace P5blog\models;

/**
 * Class Comment
 * @package P5blog\models
 */
final class Comment extends AbstractEntity
{
    private int $id;
    private int $postId;
    private string $author;
    private string $content;
    private string $modificationdate;

    /**
     * Retrieve all comments related to a blog post, stocked in database.
     * @param int $postId
     * @return array collection of comments.
     */
    public static function retrieveFromPost(int $postId): array
    {
        $db = self::dbconnect();

        $query = $db->prepare("SELECT comment.id, comment.title, DATE_FORMAT(comment.modification_date, \"%W, %e %M %Y\") as modificationdate, comment.content, comment.author FROM comment LEFT JOIN post ON comment.post_id = post.id WHERE post_id = :postid ORDER BY modification_date DESC");
        $query->bindValue(':postid', $postId, \PDO::PARAM_INT);

        $query->execute();
        $response = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    /**
     * Retrieve all comments not yet validated, stocked in database.
     * @return array collection of comments.
     */
    public static function retrievePending(): array
    {
        $db = self::dbconnect();

        $query = $db->prepare("SELECT comment.id, comment.title, DATE_FORMAT(comment.modification_date, \"%W, %e %M %Y\") as modificationdate, comment.content, comment.author FROM comment WHERE valid = 0 ORDER BY modification_date ");

        $query->execute();
        $response = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    /**
     * Insert this comment into database
     * @return bool states if record was successful or not.
     */
    public function createOne(): bool
    {
        $db = self::dbconnect();

        $query = $db->prepare('INSERT INTO comment (modification_date, author, content) VALUES (NOW(), :author, :content)');
        $query->bindValue(':author', $this->author, \PDO::PARAM_INT);
        $query->bindValue(':content', $this->content, \PDO::PARAM_STR);

        return $query->execute();
    }

    /**
     * Update this comment into database
     * @return bool if successfully recorded on db or not.
     */
    public function updateOne(): bool
    {
        $db = self::dbconnect();

        $query = $db->prepare('UPDATE comment SET content = :content, modification_date = NOW() WHERE id = :id');
        $query->bindValue(':content', $this->content, \PDO::PARAM_STR);
        $query->bindValue(':id', $this->id, \PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * Delete this comment
     * @return bool states if record was successful or not.
     */
    public function deleteOne(): bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('DELETE FROM comment WHERE id = :id');
        $query->bindValue(':id', $this->id, \PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * Valid this comment
     * @return bool states if record was successful or not.
     */
    public function validate(): bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('UPDATE comment SET valid = 1 WHERE id = :id');
        $query->bindValue(':id', $this->id, \PDO::PARAM_INT);

        return $query->execute();
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setModificationdate(string $modificationdate): void
    {
        $this->modificationdate = $modificationdate;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setAuthor(string $author): void
    {
        if (strlen($author) > 10)
            throw new \Exception('Nom trop long !');

        $this->author = $author;
    }
}