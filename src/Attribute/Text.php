<?php

namespace App\Attribute;

#[\Attribute]
class Text implements EntityAttribute, NullableAttribute
{
    public bool $nullable;

    public function __construct(bool $nullable = false)
    {
        $this->nullable = $nullable;
    }

    public function getType(): string
    {
        return 'TEXT';
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}