<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateLocationCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateLocationCommand::class)]
final class CreateLocationCommandTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $latitude = 43.455252;
        $longitude = 5.475261;

        $command = new CreateLocationCommand(
            latitude: $latitude,
            longitude: $longitude,
        );

        self::assertEquals(
            $latitude,
            $command->latitude,
        );
        self::assertEquals(
            $longitude,
            $command->longitude,
        );
    }
}
