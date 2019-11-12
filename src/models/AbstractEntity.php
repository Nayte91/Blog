<?php

namespace P5blog\models;

abstract class AbstractEntity
{
    use DBConnector;

    protected $db;

    public function __construct(?array $table)
    {
        $this->hydrate($table);
    }

    public function hydrate(?array $table): void
    {
        foreach ($table as $column => $value){
            $method = "set".ucfirst($column);
            if (method_exists($this, $method))
                $this->$method($value);
        }
    }
}
