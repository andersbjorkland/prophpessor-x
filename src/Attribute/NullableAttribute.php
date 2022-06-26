<?php

namespace App\Attribute;

interface NullableAttribute
{
    public function isNullable(): bool;
}