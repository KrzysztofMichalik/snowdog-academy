<?php

use Silly\Application;
use Snowdog\Academy\Repository\CommandRepository;

$container = require __DIR__ . '/app/bootstrap.php';

$app = new Application();
$app->useContainer($container, true);

CommandRepository::getInstance()->applyCommands($app);

$app->run();
