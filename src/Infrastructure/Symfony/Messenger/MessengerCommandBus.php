<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Messenger;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\CommandInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

use function current;

final class MessengerCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $commandBus,
    ) {
        $this->messageBus = $commandBus;
    }

    /**
     * @template T
     *
     * @return T
     */
    public function dispatch(CommandInterface $command): mixed
    {
        try {
            /** @var T */
            return $this->handle($command);
        } catch (HandlerFailedException $exception) {
            $currentException = current($exception->getWrappedExceptions());

            if ($currentException) {
                throw $currentException;
            }

            throw $exception;
        }
    }
}
