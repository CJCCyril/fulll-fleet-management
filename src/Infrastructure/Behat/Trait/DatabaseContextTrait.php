<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

use App\Infrastructure\Persistence\InMemory\InMemoryDatabase;
use Symfony\Component\Process\Process;

trait DatabaseContextTrait
{
    /**
     * @BeforeScenario
     */
    public function resetDatabase(): void
    {
        InMemoryDatabase::reset();

        $process = new Process(['bin/console', 'd:s:d',  '--force' ,'--env=test']);
        $process->mustRun();
        $process = new Process(['bin/console', 'd:s:c','--env=test']);
        $process->mustRun();
    }
}
