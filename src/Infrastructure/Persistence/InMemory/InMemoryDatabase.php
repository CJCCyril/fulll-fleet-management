<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Fleet;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;

final class InMemoryDatabase
{
    /**
     * @var static|null
     */
    private static ?self $database = null;

    /**
     * @var array<class-string, array<int, object>>
     */
    public array $storage = [
        Fleet::class => [],
        Vehicle::class => [],
        Location::class => [],
    ];

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function create(): self
    {
        if (!self::$database) {
            self::$database = new self();
        }

        return self::$database;
    }

    public static function reset(): void
    {
        self::create()->storage = [
            Fleet::class => [],
            Vehicle::class => [],
            Location::class => [],
        ];
    }

    private function __clone(): void
    {
    }
}
