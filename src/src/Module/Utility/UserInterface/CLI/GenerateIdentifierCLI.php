<?php

declare(strict_types=1);

namespace App\Module\Utility\UserInterface\CLI;

use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate:identifier')]
final class GenerateIdentifierCLI extends Command
{
    public function __construct(
        private readonly IdentifierGeneratorInterface $identifierGenerator
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $identifier = $this->identifierGenerator->generate();

        $output->writeln(
            sprintf('<info>Generated new identifier:</> %s', $identifier->getValue())
        );

        return Command::SUCCESS;
    }
}
