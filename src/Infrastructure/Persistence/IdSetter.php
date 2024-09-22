<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use ReflectionClass;
use ReflectionException;

final readonly class IdSetter
{
    /**
     * @param positive-int $id
     *
     * @throws ReflectionException
     */
    public static function setId(object $entity, int $id): void
    {
        $reflection = new ReflectionClass($entity);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($entity, $id);
    }
}
