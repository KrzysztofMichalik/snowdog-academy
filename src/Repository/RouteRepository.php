<?php

namespace Snowdog\Academy\Repository;

use FastRoute\RouteCollector;

class RouteRepository
{
    private static RouteRepository $instance;
    private array $routes = [];
    private const HTTP_METHOD = 'http_method';
    private const ROUTE = 'route';
    private const CLASS_NAME = 'class_name';
    private const METHOD_NAME = 'method_name';

    public static function getInstance(): RouteRepository
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function registerRoute(string $httpMethod, string $route, string $className, string $methodName): void
    {
        $instance = self::getInstance();
        $instance->addRoute($httpMethod, $route, $className, $methodName);
    }

    public function __invoke(RouteCollector $routeCollector)
    {
        foreach ($this->routes as $route) {
            $routeCollector->addRoute(
                $route[self::HTTP_METHOD],
                $route[self::ROUTE],
                [
                    $route[self::CLASS_NAME],
                    $route[self::METHOD_NAME]
                ]
            );
        }
    }

    private function addRoute(string $httpMethod, string $route, string $className, string $methodName): void
    {
        $this->routes[] = [
            self::HTTP_METHOD => $httpMethod,
            self::ROUTE => $route,
            self::CLASS_NAME => $className,
            self::METHOD_NAME => $methodName,
        ];
    }
}