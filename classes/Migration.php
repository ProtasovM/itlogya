<?php

abstract class Migration
{
    protected Db $db;

    public function __construct()
    {
        $this->db = new Db();
    }

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