<?php

namespace App\Tests\Application\Query;

use App\Application\Query\FindFleetQuery;
use App\Application\Query\FindFleetQueryHandler;
use App\Domain\Exception\MissingResourceException;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(FindFleetQueryHandler::class)]
#[CoversClass(MissingResourceException::class)]
#[UsesClass(FindFleetQuery::class)]
final class FindFleetQueryHandlerTest extends TestCase
{
    public function testItFindsFleet(): void
    {
        $fleet = new Fleet('userId');
        $repository = $this->createMock(FleetRepository::class);
        $repository->expects($this->once())
            ->method('findOneById')
            ->willReturn($fleet);

        $query = new FindFleetQuery(1);
        $handler = new FindFleetQueryHandler($repository);
        $fleet = $handler($query);

        self::assertSame($fleet, $fleet);
    }

    public function testItThrowsMissingResourceException(): void
    {
        $repository = $this->createMock(FleetRepository::class);
        $repository->method('findOneById')
            ->willReturn(null);

        self::expectException(MissingResourceException::class);

        $message = sprintf(
            '"%s" with id "%d" not found.',
            Fleet::class,
            1,
        );
        self::expectExceptionMessage($message);

        $query = new FindFleetQuery(1);
        $handler = new FindFleetQueryHandler($repository);
        $handler($query);
    }
}
