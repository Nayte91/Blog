<?php

namespace P5blog\models;

trait DBConnector
{
    protected static function dbconnect(): \PDO
    {
        Require_once './config.php';

        try
        {
            return new \PDO($dsn, $login,  $pass);
        }

        catch(\Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}
