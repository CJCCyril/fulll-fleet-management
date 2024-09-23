<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

use function abs;

#[ORM\Entity]
class Location implements Identifiable
{
    use IdentifiableTrait;

    /**
     * @var float Latitude in degrees
     */
    #[ORM\Column(type: 'float')]
    private readonly float $latitude;

    /**
     * @var float Longitude in degrees
     */
    #[ORM\Column(type: 'float')]
    private readonly float $longitude;

    /**
     * @var float|null Altitude in meters
     */
    #[ORM\Column(type: 'float', nullable: true)]
    private readonly float|null $altitude;

    public function __construct(
        float $latitude,
        float $longitude,
        float|null $altitude = null,
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function equalTo(Location $otherLocation): bool
    {
        return
            $this->isEqual($this->getLatitude(), $otherLocation->getLatitude()) &&
            $this->isEqual($this->getLongitude(), $otherLocation->getLongitude()) &&
            $this->isEqual($this->getAltitude(), $otherLocation->getAltitude())
        ;
    }

    private function isEqual(float|null $val1, float|null $val2): bool
    {
        if (null === $val1 && null === $val2) {
            return true;
        }

        $tolerance = 0.0001;

        return abs($val1 - $val2) < $tolerance;
    }
}
