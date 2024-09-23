<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Repository\VehicleRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
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
