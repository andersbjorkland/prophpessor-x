<?php

namespace App\Attribute;

#[\Attribute]
class DateTime implements EntityAttribute, NullableAttribute
{
    public string $format;
    public bool $nullable;

    public function __construct(string $format = 'Y-m-d H:i:s', bool $nullable = false)
    {
        $this->format = $format;
        $this->nullable = $nullable;
    }

    public function getType(): string
    {
        return 'DateTime';
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}