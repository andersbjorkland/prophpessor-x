<?php

namespace App\Attribute;

#[\Attribute]
class PrimaryKey implements EntityAttribute, NullableAttribute
{
    public const NAME = 'Primary Key';
    public string $strategy;
    public bool $nullable;

    public function __construct(string $strategy = 'AUTO_INCREMENT', bool $nullable = false)
    {
        $this->strategy = $strategy;
        $this->nullable = $nullable;
    }

    public function getType(): string
    {
        return 'INT UNSIGNED';
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}