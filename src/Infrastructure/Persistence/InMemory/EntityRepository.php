<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Identifiable;
use App\Infrastructure\Persistence\IdSetter;
use ReflectionException;

use function count;

/**
 * @template T of Identifiable
 */
abstract readonly class EntityRepository
{
    private InMemoryDatabase $database;

    /**
     * @param class-string $className
     */
    public function __construct(
        protected string $className,
    ) {
        $this->database = InMemoryDatabase::create();
    }

    /**
     * @throws ReflectionException
     */
    protected function insert(Identifiable $entity): void
    {
        IdSetter::setId($entity, $this->getNextId());

        $this->persist($entity);
    }

    protected function persist(Identifiable $entity): void
    {
        $this->database->storage[$this->className][$entity->getId()] = $entity;
    }

    /**
     * @return T[]
     */
    protected function all(): array
    {
        /** @var T[] $entities */
        $entities = $this->database->storage[$this->className];

        return $entities;
    }

    /**
     * @return positive-int
     */
    private function getNextId(): int
    {
        return count($this->all()) + 1;
    }
}
