<?php

namespace App\Tests\Application\Command;

use App\Application\Command\ParkVehicleCommand;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParkVehicleCommand::class)]
#[UsesClass(Location::class)]
#[UsesClass(Vehicle::class)]
class ParkVehicleCommandTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $location = new Location(
            latitude: 43.455252,
            longitude: 5.475261,
        );

        $vehicle = new Vehicle('GG-123-WP');

        $command = new ParkVehicleCommand(
            location: $location,
            vehicle: $vehicle,
        );

        self::assertEquals(
            [
                'location' => $location,
                'vehicle' => $vehicle,
            ],
            [
                'location' => $command->location,
                'vehicle' => $command->vehicle,
            ],
        );
    }
}
