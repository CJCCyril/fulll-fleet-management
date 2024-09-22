<?php

declare(strict_types=1);

namespace App\Application\Command;

final readonly class CreateFleetCommand
{
    /**
     * @param non-empty-string $userId
     */
    public function __construct(
        public string $userId,
    ) {
        //validate non empty
    }
}
