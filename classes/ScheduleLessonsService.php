<?php

/**
 * Основная идея в том чтобы отдавать инстансы уроков, если там проставлен ученик и ид, значит время занято
 */
class ScheduleLessonsService
{
    public const START_DAY_HOUR = '9';
    public const END_DAY_HOUR = '18';

    public function __construct(
        public LessonService $lessonService,
    ){
    }

    public function getWeekTitle(DateTime $date): string
    {
        $days = $this->getDaysOfWeek($date);
        /** @var DateTime $beginDay */
        $beginDay =  reset($days);
        /** @var DateTime $endDay */
        $endDay = end($days);

        return $beginDay->format('m.d') . '-' . $endDay->format('m.d');
    }

    public function resolveWeek(Request $request): DateTime
    {
        if (isset($request->params()['week'])) {
            return DateTime::createFromFormat('y.m.d', (string) $request->params()['week']);
        }
        return new DateTime();
    }

    public function getPrevWeekDate(DateTime $date): string
    {
        return (clone $date)->modify('- 1 week')->format('y.m.d');
    }

    public function getNextWeekDate(DateTime $date): string
    {
        return (clone $date)->modify('+ 1 week')->format('y.m.d');
    }

    public function getPartsForWeekByCourse(Course $course, DateTime $date)
    {
        $out = [];
        foreach ($this->getDaysOfWeek($date) as $day) {
            /** @var DateTime $day */
            $out[] = $this->getPartsForDayByCourse(
                $course,
                $day
            );
        }
        return $out;
    }

    private function getDaysOfWeek(DateTime $date)
    {
        $startOfWeek = (clone $date)->modify('last Monday');
        $out = [];
        $out[] = $startOfWeek;
        for ($i=1;$i<=4;$i++) {
            $out[] = (clone $startOfWeek)->modify('+ ' . $i . 'day');
        }
        return $out;
    }

    public function getPartsForDayByCourse(Course $course, DateTime $date)
    {
        $timeStarts = $this->getStartTimesForDay($date);
        $teachers = $this->getTeachersByCourse($course);
        $lessons = $this->getLessonsByDayAndCourse($course, $date);

        $out = [];
        foreach ($timeStarts as $timeStart) {
            /** @var DateTime $timeStart */
            $out[$timeStart->getTimestamp()] = [
                'title' => $this->makeTitleForLessonDayPart($timeStart),
                'lessons' => [],
            ];
            foreach ($teachers as $teacher) {
                $lesson = $this->getLessonForDayHourFromArray(
                    $teacher,
                    $timeStart,
                    $lessons
                );
                if (!$lesson) {
                    $lesson = new Lesson([
                        'teacher_id' => $teacher->id,
                        'start_at' => $timeStart->getTimestamp(),
                        'course_id' => $course->id,
                        'student_id' => null,
                    ]);
                } else {
                    $lesson->student = Student::find($lesson->student_id);
                }
                $lesson->teacher = $teacher;
                $out[$timeStart->getTimestamp()]['lessons'][] = $lesson;
            }
        }

        return $out;
    }

    private function makeTitleForLessonDayPart(DateTime $dateTime): string
    {
        $title = $dateTime->format('H:i') . '-';
        $title .= (clone $dateTime)->modify('+ 1 hour')->format('H:i');

        return $title;
    }

    private function getLessonForDayHourFromArray(Teacher $teacher, DateTime $time, array $lessons)
    {
        $lessons =  array_filter(
            $lessons,
            function ($lesson) use ($teacher, $time) {
                if (
                    $lesson->teacher_id === $teacher->id
                    && $lesson->start_at === $time->getTimestamp()
                ) {
                    return true;
                }
                return false;
            }
        );

        return $lessons[0] ?? [];
    }

    private function getLessonsByDayAndCourse(Course $course, DateTime $day)
    {
        $beginOfDay = (clone $day)->modify('today')->getTimestamp();
        $endOfDay = (clone $day)->modify('tomorrow')->getTimestamp() - 1;

        return Lesson::selectWhere(
            'course_id=? and start_at BETWEEN ? and ?',
            [
                [
                    'value' => $course->id,
                    'type' => PDO::PARAM_INT,
                ],
                [
                    'value' => $beginOfDay,
                    'type' => PDO::PARAM_INT,
                ],
                [
                    'value' => $endOfDay,
                    'type' => PDO::PARAM_INT,
                ]
            ]
        );
    }

    private function getTeachersByCourse(Course $course)
    {
        $pivots = TeacherCourse::selectWhere(
            'course_id=?',
            [
                [
                    'value' => $course->id,
                    'type' => PDO::PARAM_INT,
                ],
            ]
        );

        if (!count($pivots)) {
            return [];
        } else {
            return array_map(
                function ($pivot) {
                    return Teacher::find($pivot->teacher_id);
                },
                $pivots
            );
        }
    }

    private function getStartTimesForDay(DateTime $date)
    {
        $out = [];

        for ($i=self::START_DAY_HOUR;$i<self::END_DAY_HOUR;$i++) {
            $out[] = (clone $date)->setTime($i, 0);
        }

        return $out;
    }
}