<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Fleet;
use App\Domain\Model\Identifiable;
use App\Domain\Repository\FleetRepository;
use ReflectionException;

/**
 * @extends EntityRepository<Fleet>
 */
final readonly class InMemoryFleetRepository extends EntityRepository implements FleetRepository
{
    public function __construct()
    {
        parent::__construct(Fleet::class);
    }

    /**
     * @param Fleet $entity
     */
    public function update(Identifiable $entity): void
    {
        $this->persist($entity);
    }

    /**
     * @param Fleet $entity
     *
     * @throws ReflectionException
     * @throws DuplicateEntryException
     */
    public function add(Identifiable $entity): void
    {
        $entry = $this->findOneByUserId($entity->getUserId());

        if ($entry) {
            throw new DuplicateEntryException(
                entity: $entry,
                column: 'userId',
                value: $entry->getUserId(),
            );
        }

        $this->insert($entity);
    }

    public function findOneByUserId(string $userId): Fleet|null
    {
        foreach ($this->all() as $fleet) {
            if ($userId === $fleet->getUserId()) {
                return $fleet;
            }
        }

        return null;
    }
}
