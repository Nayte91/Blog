<?php

namespace P5blog\models;

final class User extends AbstractEntity
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $admin;
    private $creationDate;
    private $logged;

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setName($name): void
    {
        $len = mb_strlen($name);

        if (($len > 3) || ($len < 16)){
            $this->name = trim($name);
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword($password): void
    {
        $this->password = trim($password);
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function setCreationDate($CreationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getName(): string
    {
      return $this->name;
    }

    public function isNameValid(): bool
    {
        return $this->name ?
    }

    public function isPasswordValid(): bool
    {
        return $this->password ?
    }
}
