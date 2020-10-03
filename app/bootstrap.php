<?php

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);

return $containerBuilder->build();
