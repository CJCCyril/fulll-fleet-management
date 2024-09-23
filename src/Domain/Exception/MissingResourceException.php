<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

use function sprintf;

final class MissingResourceException extends DomainException
{
    /**
     * @param class-string $className
     * @param positive-int|non-empty-string $id
     */
    public function __construct(
        string $className,
        int|string $id,
    ) {
        $message = sprintf(
            '"%s" with id "%s" not found.',
            $className,
            $id,
        );

        parent::__construct($message);
    }
}
