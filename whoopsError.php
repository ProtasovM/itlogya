<?php
global $container;
$weekDate = $container->scheduleLessonsService->resolveWeek($container->request);
?>

<div class="row">
    <div class="col-12 fs-2 text-center">
        <p>Something went wrong.</p>
        <p>Что-то пошло не так.</p>
        <p>Algo salió mal.</p>
        <p>Etwas ist schief gelaufen.</p>
    </div>
    <div class="col-12 text-center">
        <a href="
            <?php
                echo '/?week=' . $weekDate->format('y.m.d');
            ?>
        " class="btn btn-secondary">К планировщику</a>
    </div>
</div>
