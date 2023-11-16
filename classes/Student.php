<?php

class Student extends Model
{
    public const table = 'students';

    public const fields = [
        'full_name' => PDO::PARAM_STR,
    ];
}