<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateFleetCommandHandler
{
    public function __construct(
        private FleetRepository $fleetRepository,
    ) {
    }

    public function __invoke(CreateFleetCommand $command): Fleet
    {
        $fleet = new Fleet($command->userId);

        $this->fleetRepository->add($fleet);

        return $fleet;
    }
}
