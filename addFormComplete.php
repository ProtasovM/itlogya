<?php
global $container;
$weekDate = $container->scheduleLessonsService->resolveWeek($container->request);
?>

<div class="row">
    <div class="col-12 fs-2 text-center">
        <p>The activity has been created.</p>
        <p>Занятие создано.</p>
        <p>La actividad ha sido creada.</p>
        <p>Die Aktivität wurde erstellt.</p>
    </div>
    <div class="col-12 text-center">
        <a href="
            <?php
                echo '/?week=' . $weekDate->format('y.m.d');
            ?>
        " class="btn btn-success">К планировщику</a>
    </div>
</div>
