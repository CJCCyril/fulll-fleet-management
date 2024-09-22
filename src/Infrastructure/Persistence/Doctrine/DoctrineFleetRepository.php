<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Fleet;
use App\Domain\Model\Identifiable;
use App\Domain\Repository\FleetRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fleet>
 */
final class DoctrineFleetRepository extends ServiceEntityRepository implements FleetRepository
{
    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        parent::__construct($managerRegistry, Fleet::class);
    }

    public function findOneById(int $id): Fleet|null
    {
        return $this->find($id);
    }

    /**
     * @param Fleet $entity
     */
    public function add(Identifiable $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Fleet $entity
     */
    public function update(Identifiable $entity): void
    {
        $this->getEntityManager()->flush();
    }
}
