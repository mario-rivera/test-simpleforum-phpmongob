<?php
use DI\ContainerBuilder;

require __DIR__ . '/../../vendor/autoload.php';

define( 'MONGODM_CONFIG', __DIR__ . '/../../config/mongodm.php' );

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/di.php');
$container = $containerBuilder->build();

return $container;