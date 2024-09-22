<?php

namespace App\Tests\Application\Query;

use App\Application\Query\FindFleetQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FindFleetQuery::class)]
final class FindFleetQueryTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $query = new FindFleetQuery(1);

        self::assertEquals(
            1,
            $query->id,
        );
    }
}
