<?php

namespace App\Tests\Application\Command;

use App\Application\Command\RegisterVehicleCommand;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RegisterVehicleCommand::class)]
#[UsesClass(Fleet::class)]
#[UsesClass(Vehicle::class)]
final class RegisterVehicleCommandTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $fleet = new Fleet('userId');
        $vehicle = new Vehicle('GG-123-WP');

        $command = new RegisterVehicleCommand(
            fleet: $fleet,
            vehicle: $vehicle,
        );

        self::assertEquals(
            [
                'fleet' => $fleet,
                'vehicle' => $vehicle,
            ],
            [
                'fleet' => $command->fleet,
                'vehicle' => $command->vehicle,
            ],
        );
    }
}
