<?php

namespace App\Attribute;

interface CreatesDatabase
{
    public function getCreateTableSchema(): string;
}