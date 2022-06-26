<?php

namespace App\Attribute;

#[\Attribute]
class Varchar implements EntityAttribute, NullableAttribute
{
    public int $length;
    public bool $nullable;

    public function __construct(int $length = 255, bool $nullable = false)
    {
        $this->length = $length;
        $this->nullable = $nullable;
    }

    public function getType(): string
    {
        return 'VARCHAR(' . $this->length . ')';
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}