<?php

namespace App\Tests\Application\Command;

use App\Application\Command\ParkVehicleCommand;
use App\Application\Command\ParkVehicleCommandHandler;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParkVehicleCommandHandler::class)]
#[UsesClass(ParkVehicleCommand::class)]
#[UsesClass(Vehicle::class)]
#[UsesClass(Location::class)]
class ParkVehicleCommandHandlerTest extends TestCase
{
    public function testItRegisterFleet(): void
    {
        $repository = $this->createMock(VehicleRepository::class);
        $repository->expects($this->once())->method('update');

        $location = new Location(
            latitude: 43.455252,
            longitude: 5.475261,
        );
        $vehicle = new Vehicle('GG-123-WP');

        $command = new ParkVehicleCommand(
            location: $location,
            vehicle: $vehicle,
        );

        $handler = new ParkVehicleCommandHandler($repository);
        $handler($command);

        self::assertEquals(
            $location,
            $vehicle->getLocation(),
        );
    }
}
