<?php

class LessonController
{
    public function __construct(
        public Request $request,
        public LessonService $lessonService,
    ) {
    }

    public function create()
    {
        if (
            !isset($this->request->post()['course_id'])
            || !isset($this->request->post()['teacher_id'])
            || !isset($this->request->post()['start_at'])
            || !isset($this->request->post()['student_id'])
        ) {
            throw new Exception();
        }

        $teacher = Teacher::find($this->request->post()['teacher_id']);
        $course = Course::find($this->request->params()['course_id']);
        $student = Student::find($this->request->params()['student_id']);
        $startAt = (new DateTime())->setTimestamp($this->request->post()['start_at']);

        if (
            !$teacher
            || !$course
            || !$student
            || (clone $startAt)->modify('today')->getTimestamp()
                < (new DateTime('now'))->modify('today')->getTimestamp()
        ) {
            throw new Exception();
        }

        $this->lessonService->createLesson(
            $teacher,
            $course,
            $student,
            (new DateTime())->setTimestamp($this->request->post()['start_at']),
        );
    }
}