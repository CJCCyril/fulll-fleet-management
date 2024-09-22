<?php

declare(strict_types=1);

namespace App\Domain\Model;

trait IdentifiableTrait
{
    /**
     * @var positive-int
     *
     * @phpstan-ignore property.onlyRead
     */
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }
}
