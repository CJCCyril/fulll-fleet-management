<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Location;
use App\Domain\Repository\LocationRepository;

final readonly class CreateLocationCommandHandler implements AsCommandHandler
{
    public function __construct(
        private LocationRepository $locationRepository,
    ) {
    }

    public function __invoke(CreateLocationCommand $command): Location
    {
        $location = new Location(
            latitude: $command->latitude,
            longitude: $command->longitude,
        );

        $this->locationRepository->add($location);

        return $location;
    }
}
