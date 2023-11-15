<?php

require '../config.php';
require './Db.php';

abstract class Migration
{
    /**
     * Функция запускается при накате миграций
     * @return void
     */
    abstract public function up(): void;

    /**
     * Функция запускается при откате миграций
     * @return void
     */
    abstract public function down(): void;
}