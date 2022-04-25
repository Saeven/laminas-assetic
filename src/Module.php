<?php

declare(strict_types=1);

namespace Circlical\AsseticBundle;

use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\MvcEvent;

use const PHP_SAPI;

class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    /**
     * @inheritDoc
     */
    public function onBootstrap(EventInterface $e): void
    {
        if (!$e instanceof MvcEvent) {
            return;
        }

        if (PHP_SAPI !== 'cli') {
            $app = $e->getApplication();

            $app->getServiceManager()->get(Listener::class)->attach($app->getEventManager());
        }
    }

    /**
     * @inheritDoc
     */
    public function getConfig(): iterable
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
