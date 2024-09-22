<?php

namespace App\Tests\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Location;
use App\Infrastructure\Persistence\InMemory\InMemoryDatabase;
use App\Infrastructure\Persistence\InMemory\InMemoryLocationRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

#[CoversClass(InMemoryLocationRepository::class)]
#[UsesClass(Location::class)]
final class InMemoryLocationRepositoryTest extends TestCase
{
    private InMemoryLocationRepository $repository;
    private Location $location;

    public function setUp(): void
    {
        InMemoryDatabase::reset();
        $this->repository = new InMemoryLocationRepository();
        $this->location = new Location(
            latitude: 43.455252,
            longitude: 5.475261,
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testItCanAddAndFind(): void
    {
        $this->repository->add($this->location);

        $location = $this->repository->findOneById($this->location->getId());

        self::assertEquals(
            $this->location,
            $location,
        );
    }
}
