<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class Location implements Identifiable
{
    use IdentifiableTrait;

    public function __construct(
        private readonly float $latitude,
        private readonly float $longitude,
    ) {
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
