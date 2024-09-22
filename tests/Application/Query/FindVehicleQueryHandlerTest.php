<?php

namespace App\Tests\Application\Query;

use App\Application\Query\FindVehicleQuery;
use App\Application\Query\FindVehicleQueryHandler;
use App\Domain\Exception\MissingResourceException;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(FindVehicleQueryHandler::class)]
#[CoversClass(MissingResourceException::class)]
#[UsesClass(FindVehicleQuery::class)]
final class FindVehicleQueryHandlerTest extends TestCase
{
    public function testItFindsFleet(): void
    {
        $vehicle = new Vehicle('GG-123-WP');
        $repository = $this->createMock(VehicleRepository::class);
        $repository->expects($this->once())
            ->method('findOneById')
            ->willReturn($vehicle);

        $query = new FindVehicleQuery(1);
        $handler = new FindVehicleQueryHandler($repository);
        $vehicle = $handler($query);

        self::assertSame($vehicle, $vehicle);
    }

    public function testItThrowsMissingResourceException(): void
    {
        $repository = $this->createMock(VehicleRepository::class);
        $repository->method('findOneById')
            ->willReturn(null);

        self::expectException(MissingResourceException::class);

        $message = sprintf(
            '"%s" with id "%d" not found.',
            Vehicle::class,
            1,
        );
        self::expectExceptionMessage($message);

        $query = new FindVehicleQuery(1);
        $handler = new FindVehicleQueryHandler($repository);
        $handler($query);
    }
}
