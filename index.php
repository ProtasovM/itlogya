<?php
require __DIR__ . '/config.php';
global $container;

try {
    include __DIR__ . '/main.php';
} catch (Throwable $e) {
    if (DEBUG) {
        var_dump($e);
    }
    include __DIR__ . '/whoopsError.php';
}
?>
