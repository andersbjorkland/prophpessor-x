<?php

namespace App\Database;

use React\MySQL\ConnectionInterface;
use React\MySQL\Factory;
use Symfony\Component\Dotenv\Dotenv;

class DBConnection
{
    private string $dbConnectionDetails;
    private ConnectionInterface $db;

    public function __construct()
    {
        $mysqlProtocol = $_ENV['MYSQL_PROTOCOL'];
        $mysqlDatabase = $_ENV['MYSQL_DATABASE'];
        $mysqlUser = $_ENV['MYSQL_USER'];
        $mysqlPassword = $_ENV['MYSQL_PASSWORD'];
        $dbAddress = $_ENV['DB_ADDRESS'];
        $mysqlPort = $_ENV['MYSQL_PORT'];
        $this->dbConnectionDetails =
            $mysqlProtocol . '://'
            . $mysqlUser . ':' . $mysqlPassword
            . '@' . $dbAddress . ':' . $mysqlPort . '/'
            . $mysqlDatabase
        ;

        $this->db = (new Factory())->createLazyConnection($this->dbConnectionDetails);
    }

    public function getDb(): ConnectionInterface
    {
        return $this->db;
    }
}