<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateLocationCommand;
use App\Application\Command\CreateLocationCommandHandler;
use App\Domain\Repository\LocationRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateLocationCommandHandler::class)]
#[UsesClass(CreateLocationCommand::class)]
class CreateLocationCommandHandlerTest extends TestCase
{
    public function testItCreatesVehicle(): void
    {
        $repository = $this->createMock(LocationRepository::class);
        $repository->expects($this->once())->method('add');

        $latitude = 43.455252;
        $longitude = 5.475261;

        $command = new CreateLocationCommand(
            latitude: $latitude,
            longitude: $longitude,
        );
        $handler = new CreateLocationCommandHandler($repository);

        $location = $handler($command);

        self::assertEquals(
            $latitude,
            $location->getLatitude(),
        );
        self::assertEquals(
            $longitude,
            $location->getLongitude(),
        );
    }
}
