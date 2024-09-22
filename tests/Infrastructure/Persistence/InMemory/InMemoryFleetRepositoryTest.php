<?php

namespace App\Tests\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Fleet;
use App\Infrastructure\Persistence\InMemory\DuplicateEntryException;
use App\Infrastructure\Persistence\InMemory\InMemoryDatabase;
use App\Infrastructure\Persistence\InMemory\InMemoryFleetRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

use function sprintf;

#[CoversClass(InMemoryFleetRepository::class)]
#[CoversClass(DuplicateEntryException::class)]
#[UsesClass(Fleet::class)]
final class InMemoryFleetRepositoryTest extends TestCase
{
    private InMemoryFleetRepository $repository;
    private Fleet $fleet;

    public function setUp(): void
    {
        InMemoryDatabase::reset();
        $this->repository = new InMemoryFleetRepository();
        $this->fleet = new Fleet('userId');
    }

    /**
     * @throws ReflectionException
     * @throws DuplicateEntryException
     */
    public function testItCanAddAndFind(): void
    {
        $this->repository->add($this->fleet);

        $fleet = $this->repository->findOneByUserId($this->fleet->getUserId());

        self::assertEquals(
            $this->fleet,
            $fleet,
        );
    }

    /**
     * @throws ReflectionException
     * @throws DuplicateEntryException
     */
    public function testItThrowsDuplicateEntryException(): void
    {
        $this->repository->add($this->fleet);

        self::expectException(DuplicateEntryException::class);

        $message = sprintf(
            'Entry "%s" with "%s": "%s" already exists',
            Fleet::class,
            'userId',
            $this->fleet->getUserId(),
        );


        self::expectExceptionMessage($message);

        $this->repository->add($this->fleet);
    }
}
