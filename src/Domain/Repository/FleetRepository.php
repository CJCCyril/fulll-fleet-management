<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Fleet;

/**
 * @extends WriteRepository<Fleet>
 * @extends ReadRepository<Fleet>
 */
interface FleetRepository extends WriteRepository, ReadRepository
{
}
