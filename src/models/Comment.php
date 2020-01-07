<?php

namespace P5blog\models;

/**
 * Class Comment
 * @package P5blog\models
 */
final class Comment extends AbstractEntity
{
    public int $id;
    public int $postid;
    public int $userid;
    public string $content;
    public string $modificationdate;

    /**
     * Retrieve valid comments related to a blog post, stocked in database.
     * @param int $postid
     * @return array of comments properties.
     */
    public static function retrieveFromPost(int $postid): array
    {
        $db = self::dbconnect();

        $query = $db->prepare("SELECT comment.id, DATE_FORMAT(comment.modification_date, \"%W, %e %M %Y\") as modificationdate, comment.content, user.name FROM comment LEFT JOIN post ON comment.post_id = post.id LEFT JOIN user ON comment.user_id = user.id WHERE post_id = :postid AND valid = 1 ORDER BY modification_date DESC");
        $query->bindValue(':postid', $postid, \PDO::PARAM_INT);

        $query->execute();
        $response = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $response;
    }

    /**
     * Count the number of comments for a post.
     * @param int $postid
     * @return int
     */
    public static function countFromPost(int $postid): int
    {
        $db = self::dbconnect();

        $query = $db->prepare('SELECT COUNT(*) as cnt FROM comment WHERE post_id = :postid');
        $query->bindValue(':postid', $postid, \PDO::PARAM_INT);

        $query->execute();
        $response = $query->fetch(\PDO::FETCH_ASSOC);

        unset($db);
        return $response['cnt'];
    }

    /**
     * Retrieve all comments not yet validated, stocked in database.
     * @return array of comments properties.
     */
    public static function retrievePending(): array
    {
        $db = self::dbconnect();

        $query = $db->prepare("SELECT comment.id, comment.title, DATE_FORMAT(comment.modification_date, \"%W, %e %M %Y\") as modificationdate, comment.content, comment.author FROM comment WHERE valid = 0 ORDER BY modification_date ");

        $query->execute();
        $response = $query->fetchAll(\PDO::FETCH_ASSOC);

        unset($db);
        return $response;
    }

    /**
     * Insert this comment into database
     * @return bool states if record was successful or not.
     */
    public function createOne(array $data): bool
    {
        $comment = new self($data);

        $db = self::dbconnect();

        $query = $db->prepare('INSERT INTO comment (modification_date, post_id, user_id, content) VALUES (NOW(), :post, :user, :content)');
        $query->bindValue(':post', $comment->postid, \PDO::PARAM_INT);
        $query->bindValue(':user', $comment->userid, \PDO::PARAM_INT);
        $query->bindValue(':content', $comment->content, \PDO::PARAM_STR);

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

    public function setUserid(string $userid): void
    {
        $this->userid = $userid;
    }

    public function setPostid(int $postid):void
    {
        $this->postid = $postid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPostid(): int
    {
        return $this->postid;
    }

    public function getModificationdate(): string
    {
        return $this->modificationdate;
    }
}