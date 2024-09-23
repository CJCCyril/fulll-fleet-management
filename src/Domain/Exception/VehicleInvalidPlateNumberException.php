<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use function sprintf;

class VehicleInvalidPlateNumberException extends \DomainException
{
    public function __construct(string $plateNumber)
    {
        $message = sprintf(
            '"%s" is not a valid vehicle plate number.',
            $plateNumber,
        );

        parent::__construct($message);
    }
}
