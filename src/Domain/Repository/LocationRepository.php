<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Location;

/**
 * @extends WriteRepository<Location>
 */
interface LocationRepository extends WriteRepository
{
}
