<?php

declare(strict_types=1);

namespace App\Classes;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    protected PDO $pdo;

    public function __construct()
    {
        $configPath = __DIR__ . '/../config/database.php';

        if (!is_file($configPath)) {
            throw new RuntimeException('Konfiguračný súbor pre databázu nebol nájdený.');
        }

        $config = require $configPath;

        if (!is_array($config)) {
            throw new RuntimeException('Konfigurácia databázy nie je platná.');
        }

        foreach (['host', 'port', 'dbname', 'username', 'password'] as $key) {
            if (!array_key_exists($key, $config)) {
                throw new RuntimeException('Konfigurácia databázy neobsahuje kľúč: ' . $key);
            }
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $config['host'],
            $config['port'],
            $config['dbname']
        );

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $exception) {
            throw new RuntimeException('Nepodarilo sa pripojiť k databáze.', 0, $exception);
        }
    }
}