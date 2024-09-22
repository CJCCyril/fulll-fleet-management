<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

use function sprintf;

class VehicleAlreadyParkedAtLocationException extends DomainException
{
    /**
     * @param non-empty-string $plateNumber
     */
    public function __construct(string $plateNumber)
    {
        $message = sprintf(
            'Vehicle with id "%s" is already parked at location.',
            $plateNumber,
        );

        parent::__construct($message);
    }
}
