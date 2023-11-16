<?php

class TeacherCourse extends Model
{
    public const table = 'teacher_course';

    public const fields = [
        'teacher_id' => PDO::PARAM_INT,
        'course_id' => PDO::PARAM_INT,
    ];

    public function update() {}

    public function delete()
    {
        $sql = 'DELETE FROM ' . static::table;
        $sql .= ' WHERE teacher_id=? and course_id=?';

        $toPdo = [
            [
                'value' => $this->attributes['teacher_id'],
                'type' => PDO::PARAM_INT
            ],
            [
                'value' => $this->attributes['course_id'],
                'type' => PDO::PARAM_INT
            ]
        ];

        try {
            Container::instance()->db->query($sql, $toPdo);
        } catch (Throwable $e) {
            var_dump($e->getMessage());

            return false;
        }
        return true;
    }
}