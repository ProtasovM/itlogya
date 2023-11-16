<?php

class TeacherCourse extends Model
{
    public const table = 'teacher_course';

    public const fields = [
        'teacher_id' => PDO::PARAM_INT,
        'course_id' => PDO::PARAM_INT,
    ];
}