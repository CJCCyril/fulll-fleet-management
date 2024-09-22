<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat\Trait;

use Throwable;

trait ExceptionContextTrait
{
    private Throwable|null $currentException = null;
}
