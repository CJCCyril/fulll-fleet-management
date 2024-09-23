<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Identifiable;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
final class DoctrineVehicleRepository extends ServiceEntityRepository implements VehicleRepository
{
    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        parent::__construct($managerRegistry, Vehicle::class);
    }

    public function findOneById(int $id): Vehicle|null
    {
        return $this->find($id);
    }

    public function findOneByPlateNumber(string $plateNumber): Vehicle|null
    {
        return $this->findOneBy(['plateNumber' => $plateNumber]);
    }

    /**
     * @param Vehicle $entity
     */
    public function add(Identifiable $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Vehicle $entity
     */
    public function update(Identifiable $entity): void
    {
        $this->getEntityManager()->flush();
    }
}
