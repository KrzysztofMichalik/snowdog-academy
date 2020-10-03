<?php

namespace Snowdog\Academy\Component;

use Invoker\InvokerInterface;

class Menu
{
    private const CLASS_NAME = 'classname';
    private const SORT_ORDER = 'sort_order';
    private static Menu $instance;
    private array $items = [];
    private InvokerInterface $container;

    public static function getInstance(): Menu
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function register(string $className, int $sortOrder): void
    {
        $instance = self::getInstance();
        $instance->registerMenuItem($className, $sortOrder);
    }

    public static function setContainer(InvokerInterface $container): void
    {
        $instance = self::getInstance();
        $instance->registerContainer($container);
    }

    public function render(): void
    {
        require __DIR__ . '/../view/common/menu.phtml';
    }

    private function getMenus(): array
    {
        usort($this->items, fn ($a, $b) => $a[self::SORT_ORDER] <=> $b[self::SORT_ORDER]);

        return array_map(fn ($item) => $item[self::CLASS_NAME], $this->items);
    }

    private function renderItem(string $className): void
    {
        $this->container->call($className);
    }

    private function registerMenuItem(string $className, int $sortOrder): void
    {
        $this->items[] = [
            self::CLASS_NAME => $className,
            self::SORT_ORDER => $sortOrder,
        ];
    }

    private function registerContainer(InvokerInterface $container): void
    {
        $this->container = $container;
    }
}
