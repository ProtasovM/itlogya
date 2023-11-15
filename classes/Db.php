<?php

require __DIR__ . '/../config.php';

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
                $query->bindParam($k, $v['value'], $v['type']);
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
}