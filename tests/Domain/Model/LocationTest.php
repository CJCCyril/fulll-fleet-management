<?php

namespace App\Tests\Domain\Model;

use App\Domain\Model\Location;
use App\Infrastructure\Persistence\IdSetter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

#[CoversClass(Location::class)]
#[UsesClass(IdSetter::class)]
final class LocationTest extends TestCase
{
    private float $latitude = 43.455252;
    private float $longitude = 5.475261;
    private Location $location;

    public function setUp(): void
    {
        $this->location = new Location(
            latitude: $this->latitude,
            longitude: $this->longitude,
        );
    }

    public function testItCanBeCreated(): void
    {
        self::assertEquals(
            $this->latitude,
            $this->location->getLatitude(),
        );

        self::assertEquals(
            $this->longitude,
            $this->location->getLongitude(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testIdCanBeSet(): void
    {
        $id = 1;
        IdSetter::setId($this->location, 1);

        self::assertEquals(
            $id,
            $this->location->getId()
        );
    }

    public function testItCanBeCompared(): void
    {
        $location1 = new Location(
            latitude: 43.455252,
            longitude: 5.475261,
        );

        $location2 = new Location(
            latitude: 43.446716,
            longitude: 5.467333,
        );

        $this->assertFalse($location1->equalTo($location2));
        $this->assertTrue($location1->equalTo($location1));
    }
}
