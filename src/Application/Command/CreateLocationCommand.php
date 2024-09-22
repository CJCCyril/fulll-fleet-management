<?php

declare(strict_types=1);

namespace App\Application\Command;

final readonly class CreateLocationCommand
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
    }
}
