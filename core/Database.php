<?php

namespace app\core;

use PDO;

class Database
{
    public $pdo;
    public function __construct($config)
    {
        $dns = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dns, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR.'/migrations');
        var_dump($files);die;
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }

    public function getAppliedMigrations()
    {
        $statment = $this->pdo->prepare("SELECT migration FROM migrations");
        $statment->execute();

        return $statment->fetchAll(PDO::FETCH_COLUMN);
    }
}