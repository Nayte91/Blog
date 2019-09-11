<?php

namespace P5blog\models;

trait DBConnector
{
  public function connection()
  {
    try
    {
        return new \PDO('mysql:host=localhost;dbname=p5blog;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
  }
}
