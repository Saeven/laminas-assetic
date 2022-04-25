<?php

declare(strict_types=1);

namespace AsseticBundleTest;

use PHPUnit\Framework\TestCase;
use Circlical\AsseticBundle\AsseticMiddleware;
use Circlical\AsseticBundle\Factory\AsseticMiddlewareFactory;
use Circlical\AsseticBundle\Service;
use Laminas\View\Renderer\PhpRenderer;
use Prophecy\PhpUnit\ProphecyTrait;
use Interop\Container\ContainerInterface;

/**
 * @coversDefaultClass
 *
 *
 *
 *
 * Circlical\AsseticBundle\Factory\AsseticMiddlewareFactory
 */
final class AsseticMiddlewareFactoryTest extends TestCase
{

    use ProphecyTrait;

    private AsseticMiddlewareFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new AsseticMiddlewareFactory();
    }

    /**
     * @covers ::__invoke
     */
    public function testInvoke(): void
    {
        $this->assertTrue(is_callable($this->factory));

        $asseticService = $this->prophesize(Service::class);
        $phpRenderer    = $this->prophesize(PhpRenderer::class);

        $container = $this->prophesize(ContainerInterface::class);
        $container->get(Service::class)
            ->shouldBeCalled()
            ->willReturn($asseticService->reveal());

        $container->has(PhpRenderer::class)
            ->willReturn(true);

        $container->get(PhpRenderer::class)
            ->shouldBeCalled()
            ->willReturn($phpRenderer->reveal());

        $this->assertInstanceOf(
            AsseticMiddleware::class,
            $this->factory->__invoke($container->reveal(), AsseticMiddleware::class, [])
        );
    }

}
