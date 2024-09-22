<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Exception\MissingResourceException;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;

final readonly class FindVehicleQueryHandler
{
    public function __construct(
        private VehicleRepository $vehicleRepository
    ) {
    }

    public function __invoke(FindVehicleQuery $query): Vehicle
    {
        $vehicle = $this->vehicleRepository->findOneById($query->id);

        if (!$vehicle) {
            throw new MissingResourceException(
                className: Vehicle::class,
                id: $query->id,
            );
        }

        return $vehicle;
    }
}
