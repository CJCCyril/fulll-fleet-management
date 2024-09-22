<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use function sprintf;

class VehicleAlreadyRegisteredException extends \DomainException
{
    public function __construct(string $plateNumber)
    {
        $message = sprintf(
            'Vehicle "%s" is already registered.',
            $plateNumber,
        );

        parent::__construct($message);
    }
}
