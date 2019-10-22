<?php

namespace P5blog\models;

abstract class DBManager
{
    private $db;

    public function __construct()
    {
        Require './config.php';

        try
        {
            $this->db = new \PDO($dsn, $login,  $pass);
        }

        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}
