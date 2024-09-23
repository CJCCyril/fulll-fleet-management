<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;

final readonly class CreateVehicleCommandHandler implements AsCommandHandler
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
