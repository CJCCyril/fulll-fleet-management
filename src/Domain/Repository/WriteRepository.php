<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Identifiable;

/**
 * @template T of Identifiable
 */
interface WriteRepository
{
    /**
     * @param T $entity
     */
    public function add(Identifiable $entity): void;

    /**
     * @param T $entity
     */
    public function update(Identifiable $entity): void;
}
