<?php
$courses = Course::all();
global $container;

$weekDate = $container->scheduleLessonsService->resolveWeek($container->request);
?>

<div class="row mt-1">
    <div class="col-1 offset-3">
        <a href="
            <?php
                echo '/?week=' . $container->scheduleLessonsService->getPrevWeekDate($weekDate);
            ?>
        " class="btn btn-outline-primary btn-lg">Пред. неделя</a>
    </div>
    <div class="col-4 text-center fs-1">
        Неделя
        <?php
            echo $container->scheduleLessonsService->getWeekTitle($weekDate);
        ?>
    </div>
    <div class="col-1">
        <a href="
            <?php
                echo '/?week=' . $container->scheduleLessonsService->getNextWeekDate($weekDate);
            ?>
        " class="btn btn-outline-primary btn-lg">След. неделя</a>
    </div>
</div>

<div class="col-12 mt=1">
    <?php
    foreach ($courses as $course) {
        ?>
        <h2>
            Курс:
            <?php
            echo $course->language
            ?>
        </h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Понедельник</th>
                <th scope="col">Вторник</th>
                <th scope="col">Среда</th>
                <th scope="col">Четверг</th>
                <th scope="col">Пятница</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                foreach ($container->scheduleLessonsService->getPartsForWeekByCourse($course, $weekDate) as $dayTime => $dayParts) {
                    ?>
                    <td>
                        <?php
                        foreach ($dayParts as $hourTime => $hourPart) {
                            ?>
                            <div class="card border-0 mb-3" style="max-width: 18rem;">
                                <div class="card-header">
                                    <?php
                                    echo $hourPart['title'];
                                    ?>
                                </div>
                                <div class="card-body">
                                    <?php
                                    foreach ($hourPart['lessons'] as $lesson) {
                                        if ($lesson->student_id) {
                                            ?>
                                            <div class="card border-secondary mb-3" style="max-width: 18rem;">
                                                <div class="card-header">
                                                    Преподаватель:
                                                    <?php
                                                    echo $lesson->teacher->full_name
                                                    ?>
                                                </div>
                                                <div class="card-body text-secondary">
                                                    <h5 class="card-title">Занято(</h5>
                                                    <p class="card-text">
                                                        Студент:
                                                        <?php
                                                        echo $lesson->student->full_name
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="card border-success mb-3" style="max-width: 18rem;">
                                                <div class="card-header">
                                                    Преподаватель:
                                                    <?php
                                                    echo $lesson->teacher->full_name
                                                    ?>
                                                </div>
                                                <div class="card-body text-success">
                                                    <h5 class="card-title">Свободно</h5>
                                                    <a href="
                                                        <?php
                                                            echo '/add/?course_id=' . $lesson->course_id . '&teacher_id=' . $lesson->teacher_id . '&start_at=' . $lesson->start_at . '&week=' . $weekDate->format('y.m.d');
                                                        ?>
                                                    " class="btn btn-outline-primary btn-sm">Записать</a>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
            </tbody>
        </table>
        <?php
    }
    ?>
</div>
