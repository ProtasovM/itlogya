<?php

/**
 * Никакого билдера, только sql, только хардкор
 */
class Db
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
            DB_USER,
            DB_PASSWORD
        );
    }

    public function query(string $sql, array $params = null)
    {
        $query = $this->pdo->prepare($sql);

        if ($params) {
            foreach ($params as $k => $v) {
                $query->bindParam($k+1, $v['value'], $v['type'] ?? PDO::PARAM_STR);
            }
        }

        if (!$query->execute()) {
            throw new \Exception();
        }

        $out = [];
        while($row = $query->fetch()) {
            $out[] = $row;
        }
        return $out;
    }

    public function beginTransaction(): void
    {
        $this->pdo->query('START TRANSACTION');
    }

    public function commit(): void
    {
        $this->pdo->query('COMMIT');
    }

    public function rollback(): void
    {
        $this->pdo->query('ROLLBACK');
    }
}