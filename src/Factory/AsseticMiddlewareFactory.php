<?php

declare(strict_types=1);

namespace Circlical\AsseticBundle\Factory;

use Circlical\AsseticBundle\AsseticMiddleware;
use Circlical\AsseticBundle\Service as AsseticService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\PhpRenderer;

final class AsseticMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        /** @var AsseticService $asseticService */
        $asseticService = $container->get(AsseticService::class);

        // Create or retrieve the renderer from the container
        $viewRenderer = $container->has(PhpRenderer::class) ? $container->get(PhpRenderer::class) : new PhpRenderer();

        return new AsseticMiddleware($asseticService, $viewRenderer);
    }
}
