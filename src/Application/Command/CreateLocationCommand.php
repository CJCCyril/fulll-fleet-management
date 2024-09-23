<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Location;

/**
 * @implements CommandInterface<Location>
 */
final readonly class CreateLocationCommand implements CommandInterface
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
    }
}
