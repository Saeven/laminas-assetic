<?php

declare(strict_types=1);

namespace Circlical\AsseticBundle\Cli;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Symfony\Component\Console\Application;

class ApplicationFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $asseticService = $container->get('AsseticService');
        $cliApplication = new Application('AsseticBundle', '3.x');
        $cliApplication->add(new BuildCommand($asseticService));
        $cliApplication->add(new SetupCommand($asseticService));

        return $cliApplication;
    }
}
