<?php

const DB_HOST = 'localhost';
const DB_USER = 'user';
const DB_PASSWORD = 'password';
const DB_DATABASE = 'itlogya';


spl_autoload_register(function ($class) {
    include __DIR__ . '/classes/' . $class . '.php';
});

$container = Container::instance();
$container->db = new Db();