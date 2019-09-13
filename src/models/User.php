<?php

namespace P5blog\models;

final class User extends AbstractEntity
{
    private $name;
    private $email;
    private $password;
    private $admin;

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
}
