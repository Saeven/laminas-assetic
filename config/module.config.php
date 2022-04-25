<?php

namespace Circlical\AsseticBundle;

use Laminas\Mvc\Application as MvcApplication;
use Mezzio\Application as MezzioApplication;
use Laminas\View\Renderer;
use Laminas\ServiceManager\Factory\InvokableFactory;

return (function () {
        $config = [
            'service_manager'       => [
                'aliases'   => [
                    'AsseticConfiguration'  => Configuration::class,
                    'AsseticService'        => Service::class,
                    'Assetic\FilterManager' => FilterManager::class,
                ],
                'factories' => [
                    'Assetic\AssetManager'      => InvokableFactory::class,
                    'Assetic\AssetWriter'       => Factory\WriterFactory::class,
                    Service::class              => Factory\ServiceFactory::class,
                    FilterManager::class        => Factory\FilterManagerFactory::class,
                    Listener::class             => InvokableFactory::class,
                    'Circlical\AsseticBundle\Cli' => Cli\ApplicationFactory::class,
                    Configuration::class        => Factory\ConfigurationFactory::class,
                    AsseticMiddleware::class    => Factory\AsseticMiddlewareFactory::class,
                ],
            ],
            'assetic_configuration' => [
                'rendererToStrategy' => [
                    Renderer\PhpRenderer::class  => View\ViewHelperStrategy::class,
                    Renderer\FeedRenderer::class => View\NoneStrategy::class,
                    Renderer\JsonRenderer::class => View\NoneStrategy::class,
                ],
            ],
        ];

        if (class_exists(MvcApplication::class)) {
            $config['assetic_configuration']['acceptableErrors'] = [
                MvcApplication::ERROR_CONTROLLER_NOT_FOUND,
                MvcApplication::ERROR_CONTROLLER_INVALID,
                MvcApplication::ERROR_ROUTER_NO_MATCH
            ];
        }

        if (class_exists(MezzioApplication::class)) {
            // needed for Mezzio
            $config['service_manager']['factories'][Renderer\PhpRenderer::class] = InvokableFactory::class;
        }

        return $config;
    })();
