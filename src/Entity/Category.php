<?php

namespace App\Entity;

use App\Attribute\Varchar;

class Category extends AbstractEntity
{
    #[Varchar]
    private string $category;
}