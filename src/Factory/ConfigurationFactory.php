<?php

declare(strict_types=1);

namespace Circlical\AsseticBundle\Factory;

use Circlical\AsseticBundle\Configuration;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ConfigurationFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $configuration = $container->get('config');
        return new Configuration($configuration['assetic_configuration']);
    }
}
