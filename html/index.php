<?php
$container = require __DIR__ . '/../app/bootstrap/system.php';
echo $container->call(
    ['App\Http\Routing\Route', 'dispatch'],
    [$_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'])['path']]
);