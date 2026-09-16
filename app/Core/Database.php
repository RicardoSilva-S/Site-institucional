<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Database — Singleton
 * Uma única conexão PDO compartilhada por toda a aplicação.
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $cfg = require __DIR__ . '/../../config/database.php';

        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset={$cfg['charset']}";

        try {
            $this->pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // Em produção nunca exiba a mensagem real — logue e mostre erro genérico
            die('Erro de conexão com o banco de dados.');
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /** Executa uma query com parâmetros e retorna o Statement */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /** Retorna todos os resultados como array */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /** Retorna uma única linha ou null */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result ?: null;
    }

    public function begin(): void    { $this->pdo->beginTransaction(); }
    public function commit(): void   { $this->pdo->commit(); }
    public function rollback(): void { $this->pdo->rollBack(); }

    public function lastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
