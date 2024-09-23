<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Model\Vehicle;

/**
 * @implements QueryInterface<Vehicle>
 */
final readonly class FindVehicleByPlateNumberQuery implements QueryInterface
{
    /**
     * @param non-empty-string $plateNumber
     */
    public function __construct(
        public string $plateNumber,
    ) {
    }
}
