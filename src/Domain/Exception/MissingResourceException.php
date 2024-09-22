<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

use function sprintf;

final class MissingResourceException extends DomainException
{
    /**
     * @param class-string $className
     * @param positive-int $id
     */
    public function __construct(
        string $className,
        int $id,
    ) {
        $message = sprintf(
            '"%s" with id "%d" not found.',
            $className,
            $id,
        );

        parent::__construct($message);
    }
}
