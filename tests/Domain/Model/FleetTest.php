<?php

namespace App\Tests\Domain\Model;

use App\Domain\Model\Fleet;
use App\Infrastructure\Persistence\IdSetter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

#[CoversClass(Fleet::class)]
#[UsesClass(IdSetter::class)]
final class FleetTest extends TestCase
{
    /**
     * @var non-empty-string
     */
    private string $userId = 'testId';
    private Fleet $fleet;

    public function setUp(): void
    {
        $this->fleet = new Fleet(
            userId: $this->userId,
        );
    }

    public function testItCanBeCreated(): void
    {
        self::assertEquals(
            $this->userId,
            $this->fleet->getUserId(),
        );
    }

    /**
     * @throws ReflectionException
     */
    public function testIdCanBeSet(): void
    {
        $id = 1;
        IdSetter::setId($this->fleet, 1);

        self::assertEquals(
            $id,
            $this->fleet->getId()
        );
    }
}
