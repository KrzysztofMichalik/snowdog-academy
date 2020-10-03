<?php

namespace Snowdog\Academy\Core;

use Invoker\InvokerInterface;
use PDOException;
use Snowdog\Academy\Component\Migrations;

class Migration
{
    public const COMPONENT = 'component';
    public const VERSION = 'version';

    private InvokerInterface $invoker;
    private Database $database;

    public function __construct(InvokerInterface $invoker, Database $database)
    {
        $this->invoker = $invoker;
        $this->database = $database;
    }

    public function execute(): array
    {
        $migrations = Migrations::getInstance()->getComponentMigrations();
        ksort($migrations);

        $currentVersions = $this->getCurrentVersions();
        ksort($currentVersions);

        $executed = [];

        foreach ($migrations as $component => $version) {
            $currentVersion = $currentVersions[$component] ?? 0;
            for ($i = $currentVersion + 1; $i <= $version; ++$i) {
                $this->migrate($component, $i);
                $executed[] = [
                    self::COMPONENT => $component,
                    self::VERSION => $i,
                ];
            }
        }

        return $executed;
    }

    private function getCurrentVersions(): array
    {
        $this->testComponentsTable();

        $sql = $this->database->query('SELECT component, version FROM components');
        $data = $sql->fetchAll();

        $result = [];
        foreach ($data as $row) {
            $result[$row['component']] = $row['version'];
        }

        return $result;
    }

    private function migrate(string $component, int $i): void
    {
        $className = $component . '\\Migration\\Version' . $i;
        $this->invoker->call($className);

        if($this->database->errorCode() > 0) {
            throw new PDOException(implode(" ", $this->database->errorInfo()));
        }

        $sql = $this->database->prepare('INSERT INTO components (component, version) VALUES (:component, :version) ON DUPLICATE KEY UPDATE version = :version');
        $sql->bindParam(':component', $component, Database::PARAM_STR);
        $sql->bindParam(':version', $i, Database::PARAM_INT);
        $sql->execute();
    }

    private function testComponentsTable(): void
    {
        $createQuery = <<<SQL
CREATE TABLE IF NOT EXISTS `components` (
    `component` VARCHAR(255) NOT NULL UNIQUE,
    `version` SMALLINT(6) NOT NULL,
    PRIMARY KEY (`component`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 
SQL;
        $this->database->exec($createQuery);
    }
}
