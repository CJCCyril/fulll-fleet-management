<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Fleet;

/**
 * @implements CommandInterface<Fleet>
 */
final readonly class CreateFleetCommand implements CommandInterface
{
    /**
     * @param non-empty-string $userId
     */
    public function __construct(
        public string $userId,
    ) {
        //validate non empty
    }
}
