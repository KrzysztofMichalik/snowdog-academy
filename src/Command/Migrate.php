<?php

namespace Snowdog\Academy\Command;

use Exception;
use Snowdog\Academy\Core\Migration;
use Symfony\Component\Console\Output\OutputInterface;

class Migrate
{
    private Migration $migration;

    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    public function __invoke(OutputInterface $output)
    {
        try {
            $executed = $this->migration->execute();
            foreach ($executed as $row) {
                $output->writeln('Migration for <info>' . $row[Migration::COMPONENT] . '</info> version <info>' . $row[Migration::VERSION] . '</info>');
            }
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }
}
