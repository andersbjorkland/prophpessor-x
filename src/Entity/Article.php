<?php

namespace App\Entity;

use App\Attribute\ManyMany;
use App\Attribute\Text;
use App\Attribute\Varchar;
use phpDocumentor\Reflection\DocBlock\Tags\Source;

class Article extends AbstractEntity
{
    #[Varchar]
    private string $title;

    #[Text]
    private string $content;

    #[ManyMany(sourceClass: self::class, targetClass: Category::class)]
    private array $categories;
}