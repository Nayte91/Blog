<?php

namespace P5blog\models;

final class UserManager
{
    public function newOne($name , $email, $password, $admin)
    {
        $user = $this->db->prepare('INSERT INTO user(name, email, password, creation_date, admin) VALUES(?,?,?, NOW(), ?)');
        $result = $user->execute(array($name , $email, $password, $admin));

        return $result;
    }

    public function deleteOne($id)
    {

    }

    public function getOne($param)
    {

    }
}