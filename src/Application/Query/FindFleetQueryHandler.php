<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Exception\MissingResourceException;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepository;

final readonly class FindFleetQueryHandler
{
    public function __construct(
        private FleetRepository $fleetRepository
    ) {
    }

    public function __invoke(FindFleetQuery $query): Fleet
    {
        $fleet = $this->fleetRepository->findOneById($query->id);

        if (!$fleet) {
            throw new MissingResourceException(
                className: Fleet::class,
                id: $query->id,
            );
        }

        return $fleet;
    }
}
