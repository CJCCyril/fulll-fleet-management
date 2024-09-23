<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Repository\VehicleRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class RegisterVehicleCommandHandler
{
    public function __construct(
        private VehicleRepository $vehicleRepository,
    ) {
    }

    public function __invoke(RegisterVehicleCommand $command): void
    {
        $command->vehicle->register($command->fleet);

        $this->vehicleRepository->update($command->vehicle);
    }
}
