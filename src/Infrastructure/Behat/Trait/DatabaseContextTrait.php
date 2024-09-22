<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

use App\Infrastructure\Persistence\InMemory\InMemoryDatabase;

trait DatabaseContextTrait
{
    /**
     * @BeforeScenario
     */
    public function resetDatabase(): void
    {
        InMemoryDatabase::reset();
    }
}
