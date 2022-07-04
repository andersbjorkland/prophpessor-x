<?php

namespace App\Attribute;

#[\Attribute]
class PrimaryKey implements EntityAttribute
{
    public const NAME = 'Primary Key';
    public string $strategy;

    public function __construct(string $strategy = 'AUTO_INCREMENT')
    {
        $this->strategy = $strategy;
    }

    public function getType(): string
    {
        return 'INT UNSIGNED ' . $this->strategy;
    }
}