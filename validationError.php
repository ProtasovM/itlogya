<?php
global $container;
$weekDate = $container->scheduleLessonsService->resolveWeek($container->request);
?>

<div class="row">
    <div class="col-12 fs-2 text-center">
        <p>Validation error. This happens when the user enters incorrect parameters.</p>
        <p>Ошибка валидации. Такое бывает, когда пользователь вводит не верные параметры.</p>
        <p>Error de validacion. Esto sucede cuando el usuario ingresa parámetros incorrectos.</p>
        <p>Validierungsfehler. Dies geschieht, wenn der Benutzer falsche Parameter eingibt.</p>
    </div>
    <div class="col-12 text-center">
        <a href="
            <?php
                echo '/?week=' . $weekDate->format('y.m.d');
            ?>
        " class="btn btn-secondary">К планировщику</a>
    </div>
</div>
