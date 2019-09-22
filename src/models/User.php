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

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function setCreationDate($CreationDate)
    {
        $this->creationDate = $creationDate;
    }
}
