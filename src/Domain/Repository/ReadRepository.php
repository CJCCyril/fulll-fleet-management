<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Identifiable;

/**
 * @template T of Identifiable
 */
interface ReadRepository
{
    /**
     * @param positive-int $id
     *
     * @return T|null
     */
    public function findOneById(int $id): Identifiable|null;
}
