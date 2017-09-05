<?php
use DI\Container;
use function DI\object;
use function DI\factory;

return [
    'app.basedir'  => __DIR__ . '/../../',
    Twig_Environment::class => factory('App\Services\Twig\TwigServiceProvider::register')
];
