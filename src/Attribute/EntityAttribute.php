<?php

namespace App\Attribute;

interface EntityAttribute
{
    public function getType(): string;
}