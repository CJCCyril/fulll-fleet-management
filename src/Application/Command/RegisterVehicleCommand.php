<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;

final readonly class RegisterVehicleCommand
{
    public function __construct(
        public Fleet $fleet,
        public Vehicle $vehicle,
    ) {
    }
}
