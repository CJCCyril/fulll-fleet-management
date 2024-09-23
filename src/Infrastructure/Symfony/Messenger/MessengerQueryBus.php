<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Messenger;

use App\Application\Query\QueryBusInterface;
use App\Application\Query\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

use function current;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $queryBus,
    ) {
        $this->messageBus = $queryBus;
    }

    /**
     * @template T
     *
     * @return T
     */
    public function ask(QueryInterface $query): mixed
    {
        try {
            /** @var T */
            return $this->handle($query);
        } catch (HandlerFailedException $exception) {
            $currentException = current($exception->getWrappedExceptions());

            if ($currentException) {
                throw $currentException;
            }

            throw $exception;
        }
    }
}
