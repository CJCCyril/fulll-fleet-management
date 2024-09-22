<?php

namespace App\Tests\Application\Command;

use App\Application\Command\CreateVehicleCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateVehicleCommand::class)]
final class CreateVehicleCommandTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $command = new CreateVehicleCommand('GG-123-WP');

        self::assertEquals(
            'GG-123-WP',
            $command->plateNumber,
        );
    }
}
