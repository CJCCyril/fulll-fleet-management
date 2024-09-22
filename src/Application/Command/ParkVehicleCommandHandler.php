<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Repository\VehicleRepository;

final readonly class ParkVehicleCommandHandler
{
    public function __construct(
        private VehicleRepository $vehicleRepository,
    ) {
    }

    public function __invoke(ParkVehicleCommand $command): void
    {
        $command->vehicle->park($command->location);

        $this->vehicleRepository->update($command->vehicle);
    }
}
