<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Identifiable;
use App\Domain\Model\Vehicle;

/**
 * @extends WriteRepository<Vehicle>
 * @extends ReadRepository<Vehicle>
 */
interface VehicleRepository extends WriteRepository, ReadRepository
{
    /**
     * @param non-empty-string $plateNumber
     *
     * @return Vehicle|null
     */
    public function findOneByPlateNumber(string $plateNumber): Identifiable|null;
}
