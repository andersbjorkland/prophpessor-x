<?php

namespace App\Entity;

use App\Attribute\Text;
use App\Attribute\Varchar;

class Article extends AbstractEntity
{
    #[Varchar]
    private string $title;

    #[Text]
    private string $content;
}