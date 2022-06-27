<?php

namespace App\Attribute;

#[\Attribute]
class DateTime implements EntityAttribute, NullableAttribute
{
    public string $format;
    public bool $nullable;
    public string $default;

    public function __construct(string $format = 'Y-m-d H:i:s', bool $nullable = false, string $default = 'DEFAULT CURRENT_TIMESTAMP')
    {
        $this->format = $format;
        $this->nullable = $nullable;
        $this->default = $default;
    }

    public function getType(): string
    {
        return 'DateTime ' . $this->default;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}