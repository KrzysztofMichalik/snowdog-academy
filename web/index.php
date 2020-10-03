<?php

use FastRoute\Dispatcher;
use Snowdog\Academy\Repository\RouteRepository;
use Snowdog\Academy\Component\Menu;

session_start();

$container = require __DIR__ . '/../app/bootstrap.php';
$routeRepository = RouteRepository::getInstance();
$dispatcher = FastRoute\simpleDispatcher($routeRepository);
Menu::setContainer($container);

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
switch($route[0]) {
    case Dispatcher::NOT_FOUND:
        header('HTTP/1.0 404 Not Found');
        require __DIR__ . '/../src/view/errors/404.phtml';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        header('HTTP/1.0 405 Method Not Allowed');
        require __DIR__ . '/../src/view/errors/405.phtml';
        break;
    case Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $container->call($controller, $parameters);
        break;
}
