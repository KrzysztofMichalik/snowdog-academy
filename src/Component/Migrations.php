<?php

namespace Snowdog\Academy\Component;

class Migrations
{
    private static Migrations $instance;
    private array $components = [];

    public static function getInstance(): Migrations
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function registerComponentMigration(string $component, int $version): void
    {
        $instance = self::getInstance();
        $instance->addComponentMigration($component, $version);
    }

    private function addComponentMigration(string $component, int $version): void
    {
        $this->components[$component] = $version;
    }

    public function getComponentMigrations(): array
    {
        return $this->components;
    }
}
