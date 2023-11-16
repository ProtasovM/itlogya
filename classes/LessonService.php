<?php

class LessonService
{
    public function __construct(
        public Db $db,
    ){
    }

    public function createLesson(
        Teacher $teacher,
        Course $course,
        Student $student,
        DateTime $startAt
    ) {
        //$this->db->beginTransaction(); //можно индекс сделать в принципе
        $lessonTeacher = Lesson::selectWhere(
            'teacher_id=? and start_at=?',
            [
                [
                    'value' => $teacher->id,
                    'type' => PDO::PARAM_INT,
                ],
                [
                    'value' => $startAt->getTimestamp(),
                    'type' => PDO::PARAM_INT,
                ]
            ]
        );
        $lessonStudent = Lesson::selectWhere(
            'student_id=? and start_at=?',
            [
                [
                    'value' => $student->id,
                    'type' => PDO::PARAM_INT,
                ],
                [
                    'value' => $startAt->getTimestamp(),
                    'type' => PDO::PARAM_INT,
                ]
            ]
        );
        if ($lessonTeacher || $lessonStudent) {
            $this->db->rollback();
            throw new Exception();
        }
        return Lesson::create([
            'teacher_id' => $teacher->id,
            'course_id' => $course->id,
            'student_id' => $student->id,
            'start_at' => $startAt->getTimestamp(),
        ]);// транза закроется коммитом
    }
}