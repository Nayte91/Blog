<?php

namespace P5blog\models;

class DBManager
{
    use DBConnector;

    private $db;

    public function __construct()
    {
        return $this->db = $this->connection();
    }
}
