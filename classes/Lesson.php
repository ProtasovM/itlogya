<?php

class Lesson extends Model
{
    public const table = 'lessons';

    public const fields = [
        'start_at' => PDO::PARAM_STR,
        'teacher_id' => PDO::PARAM_INT,
        'course_id' => PDO::PARAM_INT,
        'student_id' => PDO::PARAM_INT,
    ];
}