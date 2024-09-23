<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use App\Domain\Exception\VehicleAlreadyRegisteredException;
use App\Domain\Exception\VehicleInvalidPlateNumberException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Vehicle implements Identifiable
{
    use IdentifiableTrait;

    //Only support french plate number
    private const string PLATE_NUMBER_REGEX = '/^[A-Z]{2}-\d{3}-[A-Z]{2}$/';

    /**
     * @var non-empty-string
     */
    #[ORM\Column(type: 'string', unique: true)]
    private readonly string $plateNumber;

    /**
     * @var Fleet[]
     */
    #[ORM\ManyToMany(
        targetEntity: Fleet::class,
        cascade: ['persist'],
    )]
    private iterable $fleets;

    #[ORM\OneToOne(
        targetEntity: Location::class,
        cascade: ['persist'],
    )]
    private Location|null $location = null;

    /**
     * @param non-empty-string $plateNumber
     */
    public function __construct(
        string $plateNumber,
    ) {
        $this->plateNumber = $plateNumber;

        $this->validate();

        $this->fleets = new ArrayCollection();
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

    /**
     * @return non-empty-string
     */
    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function register(Fleet $fleet): self
    {
        //@phpstan-ignore method.nonObject (Doctrine collection)
        if ($this->fleets->contains($fleet)) {
            throw new VehicleAlreadyRegisteredException($this->plateNumber);
        }

        //@phpstan-ignore offsetAccess.nonOffsetAccessible (Doctrine collection)
        $this->fleets[] = $fleet;

        return $this;
    }

    public function park(Location $location): self
    {
        if ($this->location?->equalTo($location)) {
            throw new VehicleAlreadyParkedAtLocationException($this->plateNumber);
        }

        $this->location = $location;

        return $this;
    }

    private function validate(): void
    {
        if (!preg_match(self::PLATE_NUMBER_REGEX, $this->plateNumber)) {
            throw new VehicleInvalidPlateNumberException($this->plateNumber);
        }
    }
}
