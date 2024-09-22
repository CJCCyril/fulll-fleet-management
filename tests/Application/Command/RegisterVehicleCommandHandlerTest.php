<?php

namespace App\Tests\Application\Command;

use App\Application\Command\RegisterVehicleCommand;
use App\Application\Command\RegisterVehicleCommandHandler;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RegisterVehicleCommandHandler::class)]
#[UsesClass(RegisterVehicleCommand::class)]
#[UsesClass(Vehicle::class)]
#[UsesClass(Fleet::class)]
class RegisterVehicleCommandHandlerTest extends TestCase
{
    public function testItRegisterFleet(): void
    {
        $repository = $this->createMock(VehicleRepository::class);
        $repository->expects($this->once())->method('update');

        $fleet = new Fleet('userId');
        $vehicle = new Vehicle('GG-123-WP');
        $command = new RegisterVehicleCommand(
            fleet: $fleet,
            vehicle: $vehicle,
        );

        $handler = new RegisterVehicleCommandHandler($repository);
        $handler($command);

        self::assertContains(
            $fleet,
            $vehicle->getFleets(),
        );
    }
}
