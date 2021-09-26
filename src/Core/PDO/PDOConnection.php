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

    private static $instance = null;

    private function __construct()
    {
        
    }

    public static function getConnection(): ?PDO
    {
        if (self::$instance === null) {
            self::$instance = new PDO(
                sprintf("mysql:dbname=%s;host=%s", self::$db_name, self::$db_host), 
                self::$db_user, 
                self::$db_pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }
        return self::$instance;
    }
}