<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Model\Vehicle;

/**
 * @implements QueryInterface<Vehicle>
 */
final readonly class FindVehicleQuery implements QueryInterface
{
    /**
     * @param positive-int $id
     */
    public function __construct(
        public int $id,
    ) {
    }
}
