<?php
require __DIR__ . '/config.php';
$courses = Course::all();
$lessons = Lesson::all();
global $container;
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My awesome language school</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand">Лучшая языковая школа</a>
                    <a class="btn btn-outline-success" type="submit">Записаться на занятие</a>
                </div>
            </nav>
            <div class="col-12">
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
                        <?php
                            //foreach ($container->scheduleLessonsService->getPartsForWeekByCourse($course, 'now') as $value) {}
                        ?>
                        <tr>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
                <?php
                    }
                ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
