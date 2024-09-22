<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\VehicleAlreadyRegisteredException;

use function in_array;

final class Vehicle implements Identifiable
{
    use IdentifiableTrait;

    /**
     * @var Fleet[]
     */
    private array $fleets = [];

    private Location|null $location = null;

    /**
     * @param non-empty-string $plateNumber
     */
    public function __construct(
        private readonly string $plateNumber,
    ) {
    }

    /**
     * @return Fleet[]
     */
    public function getFleets(): iterable
    {
        return $this->fleets;
    }

    public function getLocation(): Location|null
    {
        return $this->location;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function register(Fleet $fleet): self
    {
        if (in_array($fleet, $this->fleets, true)) {
            throw new VehicleAlreadyRegisteredException($this->plateNumber);
        }

        $this->fleets[] = $fleet;

        return $this;
    }
}
