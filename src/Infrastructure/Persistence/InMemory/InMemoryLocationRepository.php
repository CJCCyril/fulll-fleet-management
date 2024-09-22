<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Identifiable;
use App\Domain\Model\Location;
use App\Domain\Repository\LocationRepository;
use ReflectionException;

/**
 * @extends EntityRepository<Location>
 */
final readonly class InMemoryLocationRepository extends EntityRepository implements LocationRepository
{
    public function __construct()
    {
        parent::__construct(Location::class);
    }

    /**
     * @param Location $entity
     */
    public function update(Identifiable $entity): void
    {
        $this->persist($entity);
    }

    /**
     * @param Location $entity
     *
     * @throws ReflectionException
     */
    public function add(Identifiable $entity): void
    {
        $this->insert($entity);
    }

    public function findOneById(int $id): Location|null
    {
        foreach ($this->all() as $location) {
            if ($id === $location->getId()) {
                return $location;
            }
        }

        return null;
    }
}
