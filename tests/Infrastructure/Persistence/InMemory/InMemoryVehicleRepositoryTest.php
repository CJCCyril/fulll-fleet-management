<?php

namespace App\Tests\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Vehicle;
use App\Infrastructure\Persistence\InMemory\DuplicateEntryException;
use App\Infrastructure\Persistence\InMemory\InMemoryDatabase;
use App\Infrastructure\Persistence\InMemory\InMemoryVehicleRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

use function sprintf;

#[CoversClass(InMemoryVehicleRepository::class)]
#[CoversClass(DuplicateEntryException::class)]
#[UsesClass(Vehicle::class)]
final class InMemoryVehicleRepositoryTest extends TestCase
{
    private InMemoryVehicleRepository $repository;
    private Vehicle $vehicle;

    public function setUp(): void
    {
        InMemoryDatabase::reset();
        $this->repository = new InMemoryVehicleRepository();
        $this->vehicle = new Vehicle('GG-123-WP');
    }

    /**
     * @throws ReflectionException
     * @throws DuplicateEntryException
     */
    public function testItCanAddAndFind(): void
    {
        $this->repository->add($this->vehicle);

        $vehicle = $this->repository->findOneByPlateNumber($this->vehicle->getPlateNumber());

        self::assertEquals(
            $this->vehicle,
            $vehicle,
        );
    }

    /**
     * @throws ReflectionException
     * @throws DuplicateEntryException
     */
    public function testItThrowsDuplicateEntryException(): void
    {
        $this->repository->add($this->vehicle);

        self::expectException(DuplicateEntryException::class);

        $message = sprintf(
            'Entry "%s" with "%s": "%s" already exists',
            Vehicle::class,
            'plateNumber',
            $this->vehicle->getPlateNumber(),
        );


        self::expectExceptionMessage($message);

        $this->repository->add($this->vehicle);
    }
}
