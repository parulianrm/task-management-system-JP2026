<?php

namespace App\Core;

use PDO;

class Database
{
    private static ? PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $host = getenv('DB_HOST') ?: 'localhost';
            $db   = getenv('DB_NAME') ?: 'tms_jp2026';
            $user = getenv('DB_USER') ?: 'tms_parulian';
            $pass = getenv('DB_PASS') ?: '';

            $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$connection;
    }
}
