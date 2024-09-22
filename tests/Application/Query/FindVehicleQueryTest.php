<?php

namespace App\Tests\Application\Query;

use App\Application\Query\FindVehicleQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FindVehicleQuery::class)]
final class FindVehicleQueryTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $query = new FindVehicleQuery(1);

        self::assertEquals(
            1,
            $query->id,
        );
    }
}
