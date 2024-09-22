<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Identifiable;
use App\Domain\Model\Location;
use App\Domain\Repository\LocationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
final class DoctrineLocationRepository extends ServiceEntityRepository implements LocationRepository
{
    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        parent::__construct($managerRegistry, Location::class);
    }

    public function findOneById(int $id): Location|null
    {
        return $this->find($id);
    }

    /**
     * @param Location $entity
     */
    public function add(Identifiable $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Location $entity
     */
    public function update(Identifiable $entity): void
    {
        $this->getEntityManager()->flush();
    }
}
