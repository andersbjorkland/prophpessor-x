<?php

namespace App\Repository;

use React\MySQL\ConnectionInterface;

class Repository
{
    protected ConnectionInterface $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }
}