<?php

require './classes/Db.php';

const DIR = __DIR__;
const MIGRATIONS_DIR = DIR . '/migrations';
/*
 * Мой awesome мигратор
 * распарсить папку с миграциями
 * накатить в прямом порядке
 * откатить в обратном
 */

if ($argc == 1) {
    echo 'set up|down' . PHP_EOL;
    exit(1);
}
/*
 * первый аргумент up|down
 */
$arg = $argv[1];

/*
 * парсим-собираем миграции
 */
$migrations = [];
foreach (scandir(MIGRATIONS_DIR) as $filename) {
    if (str_ends_with($filename, '.php')) {
        $class = require MIGRATIONS_DIR . '/' . $filename;

        $ref = new ReflectionClass($class);

        if (
            $ref->hasMethod('up')
            && $ref->hasMethod('down')
        ) {
            $migrations[$ref->name] = $class;
        }
    }
}

/*
 * теперь надо взять что накачено
 */
$db = new Db();
$existsMigrations = [];
try {
    $existsMigrations = $db->query('SELECT * FROM migrations');
} catch (PDOException) {
    $db->query('CREATE TABLE migrations (`id` int, `class` varchar(255))');
}

if ($arg === 'up') {
    /*
     * Отрезолвим что есть
     */
    $migrations = array_filter($migrations, function ($class, $name) use ($existsMigrations) {
        foreach ($existsMigrations as $existsMigration) {
            if ($name === $existsMigration['name']) {
                return false;
            }
        }
        return true;
    });

    foreach ($migrations as $name => $migration) {
        $migration->up();

        $db->query(
            'INSERT INTO migrations (name) VALUES (?)',
            [
                [
                    'value' => $name,
                    'type' => PDO::PARAM_STR,
                ]
            ]
        );

        echo $name . ' up' . PHP_EOL;
    }
} else if ($arg === 'down') {
    foreach (array_reverse($existsMigrations) as $existMigration) {
        $migrations[$existMigration['name']]->down();

        $db->query(
            'DELETE FROM migrations WHERE id = ?',
            [
                [
                    'value' => $existMigration['id'],
                    'type' => PDO::PARAM_INT,
                ]
            ]
        );

        echo $existMigration['name'] . ' down' . PHP_EOL;
    }
}
