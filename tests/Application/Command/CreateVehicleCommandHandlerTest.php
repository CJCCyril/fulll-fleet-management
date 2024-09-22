<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateVehicleCommand;
use App\Application\Command\CreateVehicleCommandHandler;
use App\Domain\Repository\VehicleRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateVehicleCommandHandler::class)]
#[UsesClass(CreateVehicleCommand::class)]
class CreateVehicleCommandHandlerTest extends TestCase
{
    public function testItCreatesVehicle(): void
    {
        $repository = $this->createMock(VehicleRepository::class);
        $repository->expects($this->once())->method('add');

        $command = new CreateVehicleCommand('GG-123-WP');
        $handler = new CreateVehicleCommandHandler($repository);

        $vehicle = $handler($command);

        self::assertEquals(
            'GG-123-WP',
            $vehicle->getPlateNumber(),
        );
    }
}
