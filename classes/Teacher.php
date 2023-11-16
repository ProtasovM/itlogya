<?php

class Teacher extends Model
{
    public const table = 'teachers';

    public const fields = [
        'full_name' => PDO::PARAM_STR,
        'phone' => PDO::PARAM_STR,
        'email' => PDO::PARAM_STR,
    ];
}