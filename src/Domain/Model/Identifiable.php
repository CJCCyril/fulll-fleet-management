<?php

declare(strict_types=1);

namespace App\Domain\Model;

interface Identifiable
{
    /**
     * @return positive-int
     */
    public function getId(): int;
}
