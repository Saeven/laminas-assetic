<?php

declare(strict_types=1);

namespace Circlical\AsseticBundle\Factory;

use Assetic;
use Circlical\AsseticBundle\Service;
use Interop\Container\ContainerInterface;
use Laminas\Http\Request;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Mezzio\Application as MezzioApp;
use Mezzio\Helper\UrlHelper;

use function class_exists;
use function method_exists;

class ServiceFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $asseticConfig = $container->get('AsseticConfiguration');
        if ($asseticConfig->detectBaseUrl()) {
            if (class_exists(MezzioApp::class)) { // is expressive app
                $urlHelper = $container->get(UrlHelper::class);
                $asseticConfig->setBaseUrl($urlHelper->getBasePath());
            } else {
                /** @var Request $request */
                $request = $container->get('Request');
                if (method_exists($request, 'getBaseUrl')) {
                    $asseticConfig->setBaseUrl($request->getBaseUrl());
                }
            }
        }

        $asseticService = new Service($asseticConfig);
        $asseticService->setAssetManager($container->get(Assetic\AssetManager::class));
        $asseticService->setAssetWriter($container->get(Assetic\AssetWriter::class));
        $asseticService->setFilterManager($container->get(Assetic\FilterManager::class));

        // Cache buster is not mandatory
        if ($container->has('AsseticCacheBuster')) {
            $asseticService->setCacheBusterStrategy($container->get('AsseticCacheBuster'));
        }

        return $asseticService;
    }
}
