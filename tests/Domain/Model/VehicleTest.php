<?php

namespace App\Tests\Domain\Model;

use App\Domain\Exception\VehicleAlreadyParkedAtLocationException;
use App\Domain\Exception\VehicleAlreadyRegisteredException;
use App\Domain\Model\Fleet;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;
use App\Infrastructure\Persistence\IdSetter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

use function sprintf;

#[CoversClass(Vehicle::class)]
#[UsesClass(IdSetter::class)]
#[UsesClass(Fleet::class)]
#[UsesClass(Location::class)]
final class VehicleTest extends TestCase
{
    /**
     * @var non-empty-string
     */
    private string $plateNumber = 'GG-123-WP';
    private Vehicle $vehicle;

    public function setUp(): void
    {
        $this->vehicle = new Vehicle(
            plateNumber: $this->plateNumber,
        );
    }

    public function testItCanBeCreated(): void
    {
        self::assertEquals(
            $this->plateNumber,
            $this->vehicle->getPlateNumber(),
        );
        self::assertEmpty(
            $this->vehicle->getFleets(),
        );
        self::assertNull(
            $this->vehicle->getLocation(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testIdCanBeSet(): void
    {
        $id = 1;
        IdSetter::setId($this->vehicle, 1);

        self::assertEquals(
            $id,
            $this->vehicle->getId()
        );
    }

    public function testItCanAddFleet(): void
    {
        $fleet = new Fleet('userId');

        $this->vehicle->register($fleet);

        self::assertContains(
            $fleet,
            $this->vehicle->getFleets(),
        );
    }

    public function testItThrowsVehicleAlreadyRegisteredException(): void
    {
        $fleet = new Fleet('userId');

        self::expectException(VehicleAlreadyRegisteredException::class);

        $message = sprintf(
            'Vehicle "%s" is already registered.',
            $this->vehicle->getPlateNumber(),
        );

        self::expectExceptionMessage($message);

        $this->vehicle->register($fleet);
        $this->vehicle->register($fleet);
    }

    public function testItCanBeParked(): void
    {
        $latitude = 43.455252;
        $longitude = 5.475261;

        $location = new Location(
            latitude: $latitude,
            longitude: $longitude,
        );

        $this->vehicle->park($location);

        self::assertNotNull($this->vehicle->getLocation());

        self::assertEquals(
            [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ],
            [
                'latitude' => $this->vehicle->getLocation()->getLatitude(),
                'longitude' => $this->vehicle->getLocation()->getLongitude(),
            ],
        );
    }

    public function testItThrowsVehicleAlreadyParkedAtLocationException(): void
    {
        $latitude = 43.455252;
        $longitude = 5.475261;

        $location = new Location(
            latitude: $latitude,
            longitude: $longitude,
        );

        $this->vehicle->park($location);

        self::expectException(VehicleAlreadyParkedAtLocationException::class);

        $message = sprintf(
            'Vehicle with id "%s" is already parked at location.',
            $this->vehicle->getPlateNumber(),
        );
        self::expectExceptionMessage($message);

        $this->vehicle->park($location);
    }
}
