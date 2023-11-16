<?php

return new class extends Migration
{
    public function up(): void
    {
        $cources = [
            'english',
            'russian',
            'spanish',
            'deutsch',
        ];

        foreach ($cources as $cource) {
            Course::create([
                'language' => $cource,
            ]);
        }

        $teachers = [
            [
                'full_name' => 'teacher name1',
            ],
            [
                'full_name' => 'teacher name2',
            ],
            [
                'full_name' => 'teacher name3',
            ],
            [
                'full_name' => 'teacher name4',
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        $teacherCourses = [
            [
                'teacher_id' => 1,
                'course_id' => 1,
            ],
            [
                'teacher_id' => 1,
                'course_id' => 2,
            ],
            [
                'teacher_id' => 2,
                'course_id' => 2,
            ],
            [
                'teacher_id' => 3,
                'course_id' => 3,
            ],
            [
                'teacher_id' => 4,
                'course_id' => 4,
            ],
            [
                'teacher_id' => 4,
                'course_id' => 3,
            ],
        ];

        foreach ($teacherCourses as $teacherCourse) {
            TeacherCourse::create($teacherCourse);
        }

        $students = [
            [
                'full_name' => 'student name1',
                'email' => 'foo1@bar.com',
                'phone' => '89999999999'
            ],
            [
                'full_name' => 'student name2',
                'email' => 'foo2@bar.com',
                'phone' => '89999999999'
            ],
            [
                'full_name' => 'student name3',
                'email' => 'foo3@bar.com',
                'phone' => '89999999999'
            ],
            [
                'full_name' => 'student name4',
                'email' => 'foo4@bar.com',
                'phone' => '89999999999'
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        $lessons = [
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'student_id' => 1,
                'started_at' => strtotime('2023-11-16 17:00'),
            ],
            [
                'teacher_id' => 2,
                'course_id' => 2,
                'student_id' => 2,
                'started_at' => strtotime('2023-11-16 17:00'),
            ],
            [
                'teacher_id' => 1,
                'course_id' => 1,
                'student_id' => 1,
                'started_at' => strtotime('2023-11-16 18:00'),
            ],
        ];

        foreach ($lessons as $lesson) {
            $lesson = Lesson::create($lesson);
        }

        var_dump(Lesson::find(1));
        var_dump(Lesson::all());


    }

    public function down(): void
    {
    }
};