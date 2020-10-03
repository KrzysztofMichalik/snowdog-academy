<?php

namespace Snowdog\Academy\Repository;

use Silly\Application;

class CommandRepository
{
    private static CommandRepository $instance;
    private array $commands = [];
    private const COMMAND = 'command';
    private const CLASS_NAME = 'class_name';
    private const DESCRIPTION = 'description';

    public static function getInstance(): CommandRepository
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function registerCommand(string $command , string $className, string $description = ''): void
    {
        $instance = self::getInstance();
        $instance->addCommand($command, $className, $description);
    }

    public function applyCommands(Application $app): void
    {
        foreach ($this->commands as $command) {
            $app->command($command[self::COMMAND], $command[self::CLASS_NAME])
                ->descriptions($command[self::DESCRIPTION]);
        }
    }

    private function addCommand(string $command, string $className, string $description): void
    {
        $this->commands[] = [
            self::COMMAND => $command,
            self::CLASS_NAME => $className,
            self::DESCRIPTION => $description,
        ];
    }
}