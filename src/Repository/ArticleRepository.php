<?php

namespace App\Repository;

use React\Promise\PromiseInterface;

class ArticleRepository extends Repository
{
    public function initialize(): PromiseInterface
    {
        return $this->db->query('CREATE TABLE IF NOT EXISTS articles (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id)
        )');
    }
}