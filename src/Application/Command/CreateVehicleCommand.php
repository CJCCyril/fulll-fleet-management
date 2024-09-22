<?php

declare(strict_types=1);

namespace App\Application\Command;

final readonly class CreateVehicleCommand
{
    /**
     * @param non-empty-string $plateNumber
     */
    public function __construct(
        public string $plateNumber,
    ) {
    }
}
