<?php

namespace App\Tests\Application\Query;

use App\Application\Query\FindVehicleByPlateNumberQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FindVehicleByPlateNumberQuery::class)]
class FindVehicleByPlateNumberQueryTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $query = new FindVehicleByPlateNumberQuery('GG-123-WP');

        self::assertEquals(
            'GG-123-WP',
            $query->plateNumber,
        );
    }
}
