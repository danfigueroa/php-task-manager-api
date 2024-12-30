<?php

namespace Src\Database;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            // Ajustar para onde está seu config
            $config = require __DIR__ . '/../Config/config.php';
            $dbPath = $config['db_path'] ?? __DIR__ . '/task_api.db';

            $dsn = 'sqlite:' . $dbPath;

            try {
                self::$instance = new PDO($dsn);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
