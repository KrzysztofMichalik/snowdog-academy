<?php

namespace Snowdog\Academy\Command;

use Snowdog\Academy\Core\Database;
use Symfony\Component\Console\Output\OutputInterface;

class TestDbConnection
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function __invoke(OutputInterface $output)
    {
        $this->database->quote('SELECT 1');
        $output->writeln('Connected to DB');
    }
}
