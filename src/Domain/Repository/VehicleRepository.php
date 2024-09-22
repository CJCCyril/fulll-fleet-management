<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Vehicle;

/**
 * @extends WriteRepository<Vehicle>
 */
interface VehicleRepository extends WriteRepository
{
}
