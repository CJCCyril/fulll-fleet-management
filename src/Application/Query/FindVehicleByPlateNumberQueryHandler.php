<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Exception\MissingResourceException;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;

final readonly class FindVehicleByPlateNumberQueryHandler implements AsQueryHandler
{
    public function __construct(
        private VehicleRepository $vehicleRepository
    ) {
    }

    public function __invoke(FindVehicleByPlateNumberQuery $query): Vehicle
    {
        $vehicle = $this->vehicleRepository->findOneByPlateNumber($query->plateNumber);

        if (!$vehicle) {
            throw new MissingResourceException(
                className: Vehicle::class,
                id: $query->plateNumber,
            );
        }

        return $vehicle;
    }
}
