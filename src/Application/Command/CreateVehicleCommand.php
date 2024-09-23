<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Vehicle;

/**
 * @implements CommandInterface<Vehicle>
 */
final readonly class CreateVehicleCommand implements CommandInterface
{
    /**
     * @param non-empty-string $plateNumber
     */
    public function __construct(
        public string $plateNumber,
    ) {
    }
}
