<?php

class Course extends Model
{
    public const table = 'courses';

    public const fields = [
        'language' => PDO::PARAM_STR,
    ];
}