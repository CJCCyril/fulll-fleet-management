<?php

declare(strict_types=1);

namespace App\Domain\Model;

final class Fleet implements Identifiable
{
    use IdentifiableTrait;

    /**
     * @param non-empty-string $userId
     */
    public function __construct(
        private readonly string $userId,
    ) {
    }

    /**
     * @return non-empty-string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
