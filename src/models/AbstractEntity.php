<?php

namespace P5blog\models;

abstract class AbstractEntity
{
    use DBConnector;

    protected $db;

    public function __construct(?array $table)
    {
        $this->hydrate($table);
    }

    public function hydrate(?array $table): void
    {
        foreach ($table as $column => $value){
            $method = "set".ucfirst($column);
            if (method_exists($this, $method))
                $this->$method($value);
        }
    }

    public function setId(int $id): void
    {
        $this->id = (int)$id;
    }

    public function setPostid(int $postid):void
    {
        $this->postid = $postid;
    }

    public function setUserid(string $userid): void
    {
        $this->userid = $userid;
    }

    public function setModificationdate(string $modificationdate): void
    {
        $this->modificationdate = new \DateTime($modificationdate);
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

    public function setValid(bool $validity): void
    {
        $this->valid = $validity;
    }

    public function setAdmin(int $admin): void
    {
        $this->admin = (int) $admin;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setCreationdate($creationdate): void
    {
        $this->creationdate = $creationdate;
    }

    public function setEmail($email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new \Exception("C'est une adresse mail ça ?");

        $this->email = $email;
    }

    public function setName(?string $name): void
    {
        $len = mb_strlen($name);

        if (($len < 3) || ($len > 16))
            throw new \Exception("Login invalide");

        $this->name = ucfirst(trim($name));
    }

    public function getAll(): ?array
    {
        return get_object_vars($this);
    }
}
