<?php

namespace Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    /**
     * Get the PDO database connection instance.
     * Implements Singleton pattern to prevent multiple open connections.
     *
     * @return PDO
     * @throws PDOException
     */
    public static function connect(): PDO {
        if (self::$instance === null) {
            $configPath = dirname(__DIR__) . '/config/database.php';
            
            if (!file_exists($configPath)) {
                throw new PDOException("Database configuration file not found at " . $configPath);
            }

            $config = require $configPath;

            $dsn = sprintf(
                "mysql:host=%s;dbname=%s;charset=%s",
                $config['host'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                // In production, log error instead of echoing message directly
                throw new PDOException("Database connection error: " . $e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$instance;
    }

    /**
     * Helper to run queries with prepared statements.
     *
     * @param string $sql SQL query script
     * @param array $params Query parameter inputs
     * @return \PDOStatement
     */
    public static function query(string $sql, array $params = []): \PDOStatement {
        $db = self::connect();
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
