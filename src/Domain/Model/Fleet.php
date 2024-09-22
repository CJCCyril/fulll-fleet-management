<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Fleet implements Identifiable
{
    use IdentifiableTrait;

    /**
     * @var non-empty-string $userId
     */
    #[ORM\Column(type: 'string', length: 30, unique: true)]
    private readonly string $userId;

    /**
     * @param non-empty-string $userId
     */
    public function __construct(
        string $userId,
    ) {
        $this->userId = $userId;
    }

    /**
     * @return non-empty-string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
