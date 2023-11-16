<?php

/**
 * Eloquent без блекджека(
 */
abstract class Model
{
    public array $attributes;
    public const table = 'table';
    public const fields = [];

    public Db $db;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
        $this->db = Container::instance()->db;
    }

    public static function create($params): static
    {
        $sql = 'INSERT INTO ' . static::table;
        $sql .= ' (' . implode(',', array_keys($params)) . ')';
        $sql .= ' VALUES (' . implode(',', array_fill(0, count($params), '?')) . ')';

        $toPdo = [];
        foreach ($params as $key => $value) {
            $toPdo[] = [
                'value' => $value,
                'type' => self::fields[$key] ?? null
            ];
        }

        try {
            Container::instance()->db->query('START TRANSACTION');

            Container::instance()->db->query($sql, $toPdo);

            $id = Container::instance()->db->query('SELECT LAST_INSERT_ID()')[0]['LAST_INSERT_ID()'];

            Container::instance()->db->query('COMMIT');

            $params['id'] = $id;
        } catch (Throwable $e) {
            Container::instance()->db->query('ROLLBACK');

            var_dump($sql, $e->getMessage());
        }

        return new static($params);
    }

    public function save()
    {
        $params = array_filter(
            $this->attributes,
            fn ($item, $key) => $key !== 'id',
            ARRAY_FILTER_USE_BOTH
        );

        $sql = 'UPDATE ' . static::table;
        $sql .= ' SET ' . implode(
                ',',
                array_map(
                    fn ($key) => $key . '=?',
                    array_keys($params)
                )
            );

        $toPdo = [];
        foreach ($params as $key => $value) {
            $toPdo[] = [
                'value' => $value,
                'type' => self::fields[$key] ?? null
            ];
        }
        $sql .= ' WHERE id=?';

        $toPdo[] = [
            'value' => $this->attributes['id'],
            'type' => PDO::PARAM_INT
        ];

        try {
            Container::instance()->db->query($sql, $toPdo);
        } catch (Throwable $e) {
            var_dump($e->getMessage());

            return false;
        }
        return true;
    }

    public function delete()
    {
        $sql = 'DELETE FROM ' . static::table;
        $sql .= ' WHERE id=?';

        try {
            Container::instance()->db->query($sql, [['value' => $this->attributes['id'], 'type' => PDO::PARAM_INT]]);
        } catch (Throwable $e) {
            var_dump($e->getMessage());

            return false;
        }
        return true;
    }

    public function __get($key)
    {
        if (!isset($this->attributes[$key])) {
            return null;
        }
        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public static function find(int $id)
    {
        $toPdo[] = [
            'value' => $id,
            'type' => PDO::PARAM_INT
        ];

        $res = static::selectWhere('id=?', $toPdo);

        return $res[0];
    }

    public static function all()
    {
        return static::selectWhere();
    }

    public static function selectWhere(string $where = '', array $params = null)
    {
        $sql = 'SELECT * FROM ' . static::table;

        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        try {
            $res = Container::instance()->db->query($sql, $params);
        } catch (Throwable $e) {
            var_dump($e->getMessage());

            return false;
        }
        return array_map(fn ($item) => new static($item), $res);
    }
}