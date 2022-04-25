<?php

declare(strict_types=1);

namespace AsseticBundleTest;

use PHPUnit\Framework\TestCase;
use Circlical\AsseticBundle\AsseticMiddleware;
use Circlical\AsseticBundle\Service;
use Laminas\View\Renderer\PhpRenderer;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Mezzio\Router\RouteResult;

/**
 * @coversDefaultClass Circlical\AsseticBundle\AsseticMiddleware
 */
final class AsseticMiddlewareTest extends TestCase
{

    use ProphecyTrait;

    private AsseticMiddleware $middleware;

    /**
     * @var Service
     */
    private ObjectProphecy $asseticService;

    /**
     * @var PhpRenderer
     */
    private ObjectProphecy $viewRenderer;

    protected function setUp(): void
    {
        $this->asseticService = $this->prophesize(Service::class);
        $this->viewRenderer   = $this->prophesize(PhpRenderer::class);

        $this->middleware = new AsseticMiddleware(
            $this->asseticService->reveal(),
            $this->viewRenderer->reveal()
        );
    }

    /**
     * @covers ::process
     * @covers ::__construct
     */
    public function testProcess(): void
    {
        $request  = $this->prophesize(ServerRequestInterface::class);
        $handler  = $this->prophesize(RequestHandlerInterface::class);
        $response = $this->prophesize(ResponseInterface::class);

        $handler->handle(Argument::type(ServerRequestInterface::class))
            ->shouldBeCalled()
            ->willReturn($response->reveal());

        $this->asseticService->build();

        $this->asseticService->setupRenderer(Argument::type(PhpRenderer::class))
            ->willReturn(true);

        $this->assertInstanceOf(
            ResponseInterface::class,
            $this->middleware->process($request->reveal(), $handler->reveal())
        );
    }

    /**
     * @covers ::renderAssets
     */
    public function testRenderAssets(): void
    {
        $routeResult = $this->prophesize(RouteResult::class);
        $routeResult->getMatchedRouteName()
            ->shouldBeCalled()
            ->willReturn('mycuteroute');

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute(RouteResult::class)
            ->shouldBeCalled()
            ->willReturn($routeResult->reveal());

        $request->getAttribute('action', 'index')
            ->shouldBeCalled()
            ->willReturn('test');

        $request->getAttribute('controller', 'test')
            ->shouldBeCalled()
            ->willReturn('test');

        $request->getAttribute('module', 'test')
            ->shouldBeCalled()
            ->willReturn('test');

        $this->asseticService->setRouteName('mycuteroute')
            ->shouldBeCalled();

        $this->asseticService->setControllerName('test')
            ->shouldBeCalled();

        $this->asseticService->setActionName('test')
            ->shouldBeCalled();

        $this->asseticService->build()
            ->shouldBeCalled();

        $this->asseticService->setupRenderer(Argument::type(PhpRenderer::class))
            ->shouldBeCalled()
            ->willReturn(true);

        $this->middleware->renderAssets($request->reveal());
    }

}
