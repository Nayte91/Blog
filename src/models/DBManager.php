<?php

namespace P5blog\models;

trait DBManager
{
    public function dbconnect()
    {
        Require_once './config.php';

        try
        {
            return new \PDO($dsn, $login,  $pass);
        }

        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}
