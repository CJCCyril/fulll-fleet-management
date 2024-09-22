<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateFleetCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateFleetCommand::class)]
final class CreateFleetCommandTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $command = new CreateFleetCommand('userId');

        self::assertEquals(
            'userId',
            $command->userId,
        );
    }
}
