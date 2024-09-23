<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Model\Fleet;

/**
 * @implements QueryInterface<Fleet>
 */
final readonly class FindFleetQuery implements QueryInterface
{
    /**
     * @param positive-int $id
     */
    public function __construct(
        public int $id,
    ) {
    }
}
