<?php
global $container;
$weekDate = $container->scheduleLessonsService->resolveWeek($container->request);

if ($container->request->isPost()) {
    try {
        $container->lessonController->create();
        include __DIR__ . '/addFormComplete.php';
        exit;
    } catch (Exception $e) {
        include __DIR__ . '/validationError.php';
        exit;
    }
}

if (
    !isset($container->request->params()['course_id'])
    || !isset($container->request->params()['teacher_id'])
    || !isset($container->request->params()['start_at'])
) {
    include __DIR__ . '/validationError.php';
    exit;
}

$teacher = Teacher::find($container->request->params()['teacher_id']);
$course = Course::find($container->request->params()['course_id']);

if (!$course || !$teacher) {
    include __DIR__ . '/validationError.php';
    exit;
}

$students = Student::all();
?>

<form action="/add" method="post">
    <div class="mb-3">
        <label for="courseInput" class="form-label">Курс:
            <?php
                echo $course->language;
            ?>
        </label>
        <input type="hidden" id="courseInput" name="course_id" value="
            <?php
                echo $course->id;
            ?>
        ">
    </div>
    <div class="mb-3">
        <label for="teacherInput" class="form-label">Преподаватель:
            <?php
                echo $teacher->full_name;
            ?>
        </label>
        <input type="hidden" id="teacherInput" name="teacher_id" value="
            <?php
                echo $teacher->id;
            ?>
        ">
    </div>
    <div class="mb-3">
        <label for="startAtInput" class="form-label">Дата занятия:
            <?php
                echo (new DateTime)->setTimestamp($container->request->params()['start_at'])->format('y.m.d H:i');
            ?>
        </label>
        <input type="hidden" id="startAtInput" name="start_at" value="
            <?php
                echo $container->request->params()['start_at'];
            ?>
        ">
    </div>
    <div class="mb-3">
        <label for="studentSelect" class="form-label">Студент</label>
        <select id="studentSelect" name="student_id" class="form-select">
            <?php
                foreach ($students as $student) {
            ?>
                <option value="
                    <?php
                        echo $student->id;
                    ?>
                ">
                    <?php
                        echo $student->full_name;
                    ?>
                </option>
            <?php
                }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Записать</button>
    <a href="
        <?php
            echo '/?week=' . $weekDate->format('y.m.d');
        ?>
    " class="btn btn-secondary">К планировщику</a>
</form>
