<?php

declare(strict_types=1);

namespace Circlical\AsseticBundle\Cli;

use Circlical\AsseticBundle\Service;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function decoct;
use function is_dir;
use function is_readable;
use function is_writable;
use function mkdir;

class SetupCommand extends Command
{
    /**
     * The assetic service
     */
    private Service $assetic;

    public function __construct(Service $assetic)
    {
        parent::__construct('setup');
        $this->assetic = $assetic;
        $this->setDescription('Create cache and assets directories with valid permissions.');
    }

    /**
     * Executes the current command.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = $this->assetic->getConfiguration();
        $mode = null !== ($mode = $config->getUmask()) ? $mode : 0775;

        if (!$this->createPath($output, 'Cache', $config->getCachePath() ?? '', $mode)) {
            return Command::FAILURE;
        }
        if (!$this->createPath($output, 'Web', $config->getWebPath() ?? '', $mode)) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Creates a path with the needed permissions
     */
    private function createPath(OutputInterface $output, string $which, string $path, int $mode): bool
    {
        $displayMode = decoct($mode);
        $pathExists = is_dir($path);
        if (!$path) {
            $output->writeln('Creation of ' . $which . ' path skipped - no path provided');

            return true;
        }
        if (!$pathExists) {
            if (mkdir($path, $mode, true) || is_dir($path)) {
                $output->writeln($which . ' path created "' . $path . '" with mode "' . $displayMode . '"');

                return true;
            }

            $output->writeln('<error>' . $which . ' path "' . $path . '" could not be created.</error>');

            return false;
        }

        $readable = is_readable($path);
        $writable = is_writable($path);
        if ($readable && $writable) {
            $output->writeln(
                'Creation of ' . $which . ' path "' . $path . '" skipped - path exists with correct permissions'
            );

            return true;
        } elseif (!$readable && !$writable) {
            $output->writeln(
                '<error>Creation of ' . $which . ' path "' . $path . '" failed - path exists but is neither readable nor writable</error>'
            );
        } elseif (!$readable) {
            $output->writeln(
                '<error>Creation of ' . $which . ' path "' . $path . '" failed - path exists but is not readable</error>'
            );
        } else {
            $output->writeln(
                '<error>Creation of ' . $which . ' path "' . $path . '" failed - path exists but is not writable</error>'
            );
        }

        return false;
    }
}
