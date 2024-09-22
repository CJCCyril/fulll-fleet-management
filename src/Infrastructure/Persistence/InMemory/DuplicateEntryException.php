<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Identifiable;
use Exception;

use function sprintf;
use function get_class;

final class DuplicateEntryException extends Exception
{
    public function __construct(
        Identifiable $entity,
        string $column,
        string $value,
    ) {
        $message = sprintf(
            'Entry "%s" with "%s": "%s" already exists',
            get_class($entity),
            $column,
            $value,
        );

        parent::__construct($message);
    }
}
