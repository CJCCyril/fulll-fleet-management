<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateVehicleCommandHandler
{
    public function __construct(
        private VehicleRepository $vehicleRepository,
    ) {
    }

    public function __invoke(CreateVehicleCommand $command): Vehicle
    {
        $vehicle = new Vehicle($command->plateNumber);

        $this->vehicleRepository->add($vehicle);

        return $vehicle;
    }
}
