<?php

declare(strict_types=1);

namespace App\Application\Query;

final readonly class FindVehicleByPlateNumberQuery
{
    /**
     * @param non-empty-string $plateNumber
     */
    public function __construct(
        public string $plateNumber,
    ) {
    }
}
