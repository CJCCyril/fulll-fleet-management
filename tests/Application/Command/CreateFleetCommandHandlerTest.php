<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateFleetCommand;
use App\Application\Command\CreateFleetCommandHandler;
use App\Domain\Repository\FleetRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateFleetCommandHandler::class)]
#[UsesClass(CreateFleetCommand::class)]
class CreateFleetCommandHandlerTest extends TestCase
{
    public function testItCreatesFleet(): void
    {
        $repository = $this->createMock(FleetRepository::class);
        $repository->expects($this->once())->method('add');

        $command = new CreateFleetCommand('userId');
        $handler = new CreateFleetCommandHandler($repository);

        $fleet = $handler($command);

        self::assertEquals(
            'userId',
            $fleet->getUserId(),
        );
    }
}
