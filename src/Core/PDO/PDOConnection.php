<?php

namespace App\Core\PDO;

use Config\PDOConfig;
use PDO;

class PDOConnection
{
    private static $db_host = PDOConfig::DB_HOST;

    private static $db_name = PDOConfig::DB_NAME;

    private static $db_user = PDOConfig::DB_USER;

    private static $db_pass = PDOConfig::DB_PASS;

    private static $_instance = null;

    private PDO $connection;

    private function __construct()
    {
        $this->connection = new PDO(
            sprintf('mysql:dbname=%s;host=%s', self::$db_name, self::$db_host),
            self::$db_user,
            self::$db_pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public static function getConnection(): self
    {
        if (null === self::$_instance) {
            self::$_instance = new PDOConnection();
        }

        return self::$_instance;
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }
}
