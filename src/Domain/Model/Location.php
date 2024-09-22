<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Location implements Identifiable
{
    use IdentifiableTrait;

    #[ORM\Column(type: 'float')]
    private readonly float $latitude;

    #[ORM\Column(type: 'float')]
    private readonly float $longitude;

    public function __construct(
        float $latitude,
        float $longitude,
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function equalTo(Location $otherLocation): bool
    {
        $tolerance = 0.0001;

        return
            $this->getLatitude() - $otherLocation->getLatitude() < $tolerance &&
            $this->getLongitude() - $otherLocation->getLongitude() < $tolerance
        ;
    }
}
