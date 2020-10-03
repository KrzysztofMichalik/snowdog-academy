<?php

namespace Snowdog\Academy\Core;

use PDO;
use PDOException;

class Database extends PDO
{
    public function __construct()
    {
        if (!file_exists(__DIR__ . '/../../config.ini')) {
            throw new PDOException('Database connection not configured, check config.ini file');
        }

        $config = parse_ini_file(__DIR__ . '/../../config.ini');
        $hostName = $config['hostname'] ?? 'localhost';
        $dbName = $config['db_name'] ?? 'academy';
        $user = $config['user'] ?? 'root';
        $password = $config['password'] ?? '';

        parent::__construct('mysql:host=' . $hostName . ';dbname=' . $dbName . ';charset=utf8mb4', $user, $password);
    }
}
