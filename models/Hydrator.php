<?php

namespace P5blog\models;

trait Hydrator
{
    public function hydrate(array $table): void
    {
        foreach ($table as $column => $value)
        {
            $method = "set".ucfirst($column);
            if (method_exists($this, $method))
                $this->$method($value);
        }
    }
}