<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Identifiable;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;
use ReflectionException;

/**
 * @extends EntityRepository<Vehicle>
 */
final readonly class InMemoryVehicleRepository extends EntityRepository implements VehicleRepository
{
    public function __construct()
    {
        parent::__construct(Vehicle::class);
    }

    /**
     * @param Vehicle $entity
     */
    public function update(Identifiable $entity): void
    {
        $this->persist($entity);
    }

    /**
     * @param Vehicle $entity
     *
     * @throws ReflectionException
     * @throws DuplicateEntryException
     */
    public function add(Identifiable $entity): void
    {
        $entry = $this->findOneByPlateNumber($entity->getPlateNumber());

        if ($entry) {
            throw new DuplicateEntryException(
                entity: $entry,
                column: 'plateNumber',
                value: $entry->getPlateNumber(),
            );
        }

        $this->insert($entity);
    }

    public function findOneByPlateNumber(string $plateNumber): Vehicle|null
    {
        foreach ($this->all() as $vehicle) {
            if ($plateNumber === $vehicle->getPlateNumber()) {
                return $vehicle;
            }
        }

        return null;
    }
}
