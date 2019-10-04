<?php

namespace P5blog\models;

abstract class DBManager
{
    private $db;

    public function __construct()
    {
        try
        {
            $this->db = new \PDO('mysql:host=localhost;dbname=p5blog;charset=utf8', 'root', '');
        }
        
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}
