<?php

namespace P5blog\models;

final class UserManager extends DBManager
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

    public function getOne(User $user): User
    {
       $query = $this->db->prepare('SELECT * FROM user WHERE name = ?');
       $response = $query->execute($user->getName());
       $user->hydrate($response);
       return $user;
    }
}
