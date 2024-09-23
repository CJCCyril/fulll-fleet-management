<?php

declare(strict_types=1);

namespace App\Infrastructure\Behat;

use App\Infrastructure\Behat\Trait\DatabaseContextTrait;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Exception;
use Symfony\Component\Process\Process;

use function explode;
use function sprintf;
use function str_contains;

final class ConsoleContext implements Context
{
    use DatabaseContextTrait;

    private string $output;

    /**
     * @Given I run console command :command
     */
    public function iRunConsoleCommand(string $command): void
    {
        $input = explode(' ', $command);

        $process = new Process([
            'bin/console',
            ...$input,
        ]);
        $process->run();

        $this->output = $process->getOutput();
    }

    /**
     * @Then the output should contain:
     * @throws Exception
     */
    public function theOutputShouldContain(PyStringNode $expectedOutput): void
    {
        if (
            !str_contains(
                $this->output,
                (string) $expectedOutput,
            )
        ) {
            throw new Exception(
                sprintf(
                    'Expected output to contain "%s", but got "%s"',
                    $expectedOutput,
                    $this->output
                )
            );
        }
    }
}
