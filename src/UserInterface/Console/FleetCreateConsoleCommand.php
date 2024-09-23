<?php

declare(strict_types=1);

namespace App\UserInterface\Console;

use App\Application\Command\CreateFleetCommand;
use App\Application\Command\CreateFleetCommandHandler;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function is_string;
use function sprintf;

#[AsCommand(name: 'fleet:create', description: 'Create a new fleet')]
class FleetCreateConsoleCommand extends Command
{
    private string|null $userId = null;

    public function __construct(
        private readonly CreateFleetCommandHandler $createFleetCommandHandler,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'userId',
                InputArgument::REQUIRED,
                'The id of the user.'
            );
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $userId = $input->getArgument('userId');

        if (empty($userId) || !is_string($userId)) {
            $output->writeln('<fg=yellow>Parameter "userId" must be a non empty string.</>');

            return;
        }

        $this->userId = $userId;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        if (!$this->userId) {
            return Command::INVALID;
        }

        $command = new CreateFleetCommand($this->userId);

        try {
            $fleet = ($this->createFleetCommandHandler)($command);
        } catch (UniqueConstraintViolationException $exception) {
            $output->writeln('<fg=red>Fleet already exist.</>');

            $this->logger->error('fleet:create:failure', [
                'messsage' => $exception->getMessage(),
                //...
            ]);

            return Command::FAILURE;
        }

        $output->writeln('<fg=green>Fleet created.</>');

        $fleetIdMessage = sprintf(
            '<fg=blue>Fleet id: "%d".</>',
            $fleet->getId(),
        );
        $output->writeln($fleetIdMessage);

        return Command::SUCCESS;
    }
}
