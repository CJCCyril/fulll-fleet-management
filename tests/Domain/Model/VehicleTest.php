<?php

namespace App\Tests\Domain\Model;

use App\Domain\Model\Vehicle;
use App\Infrastructure\Persistence\IdSetter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

#[CoversClass(Vehicle::class)]
#[UsesClass(IdSetter::class)]
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
}
