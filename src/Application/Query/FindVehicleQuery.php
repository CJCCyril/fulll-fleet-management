<?php

declare(strict_types=1);

namespace App\Application\Query;

final readonly class FindVehicleQuery
{
    /**
     * @param positive-int $id
     */
    public function __construct(
        public int $id,
    ) {
    }
}
