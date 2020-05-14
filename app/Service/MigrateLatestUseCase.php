<?php

namespace App\Service;

use CodeIgniter\Database\MigrationRunner;

/**
 * Class MigrateLatestUseCase
 */
class MigrateLatestUseCase
{
    /**
     * @var MigrationRunner
     */
    private MigrationRunner $migration_runner;

    /**
     * @param MigrationRunner $a_migration_runner
     *
     * @return void
     */
    public function __construct(MigrationRunner $a_migration_runner)
    {
        $this->migration_runner = $a_migration_runner;
    }

    /**
     * @return void
     */
    public function __invoke()
    {
        $this->migration_runner->latest();
    }
}
