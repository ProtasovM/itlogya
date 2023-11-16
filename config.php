<?php

const DB_HOST = 'localhost';
const DB_USER = 'user';
const DB_PASSWORD = 'password';
const DB_DATABASE = 'itlogya';

const DEBUG = true;


spl_autoload_register(function ($class) {
    include __DIR__ . '/classes/' . $class . '.php';
});

global $container;
$container = Container::instance();
$container->db = new Db();
$container->lessonService = new LessonService(
    $container->db,
);
$container->scheduleLessonsService = new ScheduleLessonsService(
    $container->lessonService,
);
$container->request = new Request();
$container->lessonController = new LessonController(
    $container->request,
    $container->lessonService,
);

