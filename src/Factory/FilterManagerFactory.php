<?php

declare(strict_types=1);

namespace Circlical\AsseticBundle\Factory;

use Circlical\AsseticBundle\FilterManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class FilterManagerFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     * @return FilterManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new FilterManager($container);
    }
}
