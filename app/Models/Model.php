<?php

namespace App\Models;

use App\Core\Database;

/**
 * Model — classe base abstrata
 * Todos os Models do projeto herdam daqui.
 */
abstract class Model
{
    protected Database $db;
    protected static string $table = '';
    protected static string $pk    = 'id';
    protected array $fillable      = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Retorna todos os registros, com filtros opcionais */
    public function all(array $filtros = []): array
    {
        $sql    = "SELECT * FROM " . static::$table;
        $params = [];

        if (!empty($filtros)) {
            $condicoes = [];
            foreach ($filtros as $campo => $valor) {
                $condicoes[] = "{$campo} = ?";
                $params[]    = $valor;
            }
            $sql .= " WHERE " . implode(' AND ', $condicoes);
        }

        return $this->db->fetchAll($sql, $params);
    }

    /** Busca por PK */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE " . static::$pk . " = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    /** Insere um registro e retorna o ID gerado */
    public function insert(array $dados): int
    {
        $dados   = $this->filtrarFillable($dados);
        $campos  = implode(', ', array_keys($dados));
        $marcadores = implode(', ', array_fill(0, count($dados), '?'));

        $sql = "INSERT INTO " . static::$table . " ({$campos}) VALUES ({$marcadores})";
        $this->db->query($sql, array_values($dados));

        return $this->db->lastInsertId();
    }

    /** Atualiza um registro pelo ID */
    public function update(int $id, array $dados): bool
    {
        $dados  = $this->filtrarFillable($dados);
        $set    = implode(', ', array_map(fn($c) => "{$c} = ?", array_keys($dados)));
        $params = array_values($dados);
        $params[] = $id;

        $sql = "UPDATE " . static::$table . " SET {$set} WHERE " . static::$pk . " = ?";
        $this->db->query($sql, $params);
        return true;
    }

    /** Remove um registro pelo ID */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM " . static::$table . " WHERE " . static::$pk . " = ?";
        $this->db->query($sql, [$id]);
        return true;
    }

    /** Filtra só os campos permitidos pelo $fillable */
    protected function filtrarFillable(array $dados): array
    {
        if (empty($this->fillable)) {
            return $dados;
        }
        return array_intersect_key($dados, array_flip($this->fillable));
    }
}
