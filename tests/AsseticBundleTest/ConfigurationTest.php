<?php

declare(strict_types=1);

namespace AsseticBundleTest;

use Circlical\AsseticBundle;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-11-17 at 11:53:23.
 *
 * @coversDefaultClass Circlical\AsseticBundle\Configuration
 */
final class ConfigurationTest extends TestCase
{

    private AsseticBundle\Configuration $object;

    /**
     * Test configuration.
     */
    private array $testConfig = [
        'debug'          => true,
        'buildOnRequest' => true,
    ];

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new AsseticBundle\Configuration($this->testConfig);
    }

    /**
     * @covers ::isDebug
     */
    public function testIsDebug(): void
    {
        $this->assertTrue($this->object->isDebug());
    }

    /**
     * @covers ::setDebug
     * @covers ::isDebug
     */
    public function testSetDebug(): void
    {
        $expected = true;
        $this->assertNull($this->object->setDebug($expected));
        $this->assertEquals($expected, $this->object->isDebug());
    }

    /**
     * @covers ::isCombine
     */
    public function testIsCombine(): void
    {
        $this->assertTrue($this->object->isCombine());
    }

    /**
     * @covers ::setCombine
     * @covers ::isCombine
     */
    public function testSetCombine(): void
    {
        $expected = false;
        $this->assertNull($this->object->setCombine($expected));
        $this->assertEquals($expected, $this->object->isCombine());
    }

    /**
     * @covers ::setWebPath
     * @covers ::getWebPath
     */
    public function testSetWebPath(): void
    {
        $this->object->setWebPath(TEST_ASSETS_DIR);
        $this->assertEquals(TEST_ASSETS_DIR, $this->object->getWebPath());
        $this->assertEquals(TEST_ASSETS_DIR . '/test.js', $this->object->getWebPath('test.js'));
    }

    /**
     * @covers ::getBaseUrl
     */
    public function testGetBaseUrl(): void
    {
        $result = $this->object->getBaseUrl();
        $this->assertNull($result);
    }

    /**
     * @covers ::getBaseUrl
     * @covers ::setBaseUrl
     */
    public function testSetBaseUrl(): void
    {
        $url      = '/http://example.com';
        $expected = $url . '/';

        $result = $this->object->setBaseUrl($url);
        $this->assertNull($result);
        $this->assertEquals($expected, $this->object->getBaseUrl());
    }

    /**
     * @covers ::getBasePath
     */
    public function testGetBasePath(): void
    {
        $result = $this->object->getBasePath();
        $this->assertNull($result);
    }

    /**
     * @covers ::getBasePath
     * @covers ::setBasePath
     */
    public function testSetBasePath(): void
    {
        $url      = '/~/jone/assets';
        $expected = trim($url, '/') . '/';

        $result = $this->object->setBasePath($url);
        $this->assertNull($result);
        $this->assertEquals($expected, $this->object->getBasePath());
    }

    /**
     * @covers ::getWebPath
     */
    public function testGetWebPathFailure(): void
    {
        $this->expectException(AsseticBundle\Exception\RuntimeException::class);
        $this->object->getWebPath();
    }

    /**
     * @covers ::setCachePath
     * @covers ::getCachePath
     */
    public function testSetCachePath(): void
    {
        $result = $this->object->setCachePath(TEST_CACHE_DIR);
        $this->assertNull($result);
        $this->assertEquals(TEST_CACHE_DIR, $this->object->getCachePath());
    }

    /**
     * @covers ::getCachePath
     */
    public function testGetCachePath(): void
    {
        $result = $this->object->getCachePath();
        $this->assertNull($result);
    }

    /**
     * @covers ::getCacheEnabled
     */
    public function testGetCacheEnabled(): void
    {
        $this->assertFalse($this->object->getCacheEnabled());
    }

    /**
     * @covers ::getCacheEnabled
     * @covers ::setCacheEnabled
     */
    public function testSetCacheEnabled(): void
    {
        $expected = true;
        $this->assertNull($this->object->setCacheEnabled($expected));
        $this->assertEquals($expected, $this->object->getCacheEnabled());
    }

    /**
     * @covers ::getDefault
     */
    public function testGetDefault(): void
    {
        $expected = [
            'assets'  => [],
            'options' => [],
        ];
        $this->assertEquals($expected, $this->object->getDefault());
    }

    /**
     * @covers ::getDefault
     * @covers ::setDefault
     */
    public function testSetDefault(): void
    {
        $options  = [
            'test' => [],
        ];
        $expected = [
            'test'    => [],
            'assets'  => [],
            'options' => [],
        ];

        $result = $this->object->setDefault($options);
        $this->assertNull($result);
        $this->assertEquals($expected, $this->object->getDefault());
    }

    /**
     * @covers ::setRoutes
     */
    public function testSetRouters(): void
    {
        $expected = [
            'home' => [
                'name' => 'value',
            ],
        ];
        $result   = $this->object->setRoutes($expected);
        $this->assertNull($result);
        $this->assertEquals($expected, $this->object->getRoutes());
    }

    /**
     * @covers ::getRoutes
     */
    public function testGetRoutes(): void
    {
        $expected = [];
        $result   = $this->object->getRoutes();
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::getRoute
     */
    public function testGetRouter(): void
    {
        $result = $this->object->getRoute('test');
        $this->assertNull($result);

        $expected = ['name' => '123'];
        $result   = $this->object->getRoute('test', $expected);
        $this->assertEquals($expected, $result);

        $expected = [
            'name' => 'value',
        ];
        $routers  = [
            'home' => $expected,
        ];
        $this->object->setRoutes($routers);
        $result   = $this->object->getRoute('home');
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::getRoute
     */
    public function testMergeMultipleRouteMatches(): void
    {
        $this->object->setRoutes([
            'bar'     => [
                '@a',
                '@d'
            ],
            'foo.*'   => [
                '@a',
                '@b'
            ],
            'foo/bar' => [
                '@c'
            ]
        ]);

        $assets = $this->object->getRoute('foo/bar');
        $this->assertCount(3, $assets);
        $this->assertContains('@a', $assets);
        $this->assertContains('@b', $assets);
        $this->assertContains('@c', $assets);
        $this->assertNotContains('@d', $assets);
    }

    /**
     * @covers ::getRoute
     */
    public function testEmptyRouteMatchWillNotTriggerDefault(): void
    {
        $this->object->setRoutes(['bar' => []]);

        $assets = $this->object->getRoute('bar');
        $this->assertNotEquals('default', $assets);
        $this->assertCount(0, $assets);
    }

    /**
     * @covers ::getControllers
     * @covers ::setControllers
     */
    public function testGetControllers(): void
    {
        $expected = [];
        $result   = $this->object->getControllers();
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::getController
     * @covers ::setControllers
     */
    public function testGetController(): void
    {
        $controllerName = 'some';
        $result         = $this->object->getController($controllerName);
        $this->assertNull($result);

        $expected = ['name' => '123'];
        $result   = $this->object->getController($controllerName, $expected);
        $this->assertEquals($expected, $result);

        $expected = [
            'name' => 'value',
        ];
        $data     = [
            $controllerName => $expected,
        ];
        $this->object->setControllers($data);
        $result   = $this->object->getController($controllerName);
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::getModules
     */
    public function testGetModules(): void
    {
        $expected = [];
        $result   = $this->object->getModules();
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::getModule
     * @covers ::setModules
     * @covers ::addModule
     */
    public function testGetModule(): void
    {
        $moduleName = 'SomeModule';
        $result     = $this->object->getModule($moduleName);
        $this->assertNull($result);

        $expected = ['name' => '123'];
        $result   = $this->object->getModule($moduleName, $expected);
        $this->assertEquals($expected, $result);

        $expected = [
            'name' => 'value',
        ];
        $data     = [
            strtoupper($moduleName) => $expected,
        ];
        $this->object->setModules($data);
        $result   = $this->object->getModule($moduleName);
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::setRendererToStrategy
     */
    public function testSetRendererToStrategy(): void
    {
        $data   = [];
        $result = $this->object->setRendererToStrategy($data);
        $this->assertNull($result);
    }

    /**
     * @covers ::getStrategyNameForRenderer
     */
    public function testGetStrategyNameForRenderer(): void
    {
        $strategyName = 'some-module';
        $result       = $this->object->getStrategyNameForRenderer($strategyName);
        $this->assertNull($result);

        $expected = '123';
        $result   = $this->object->getStrategyNameForRenderer($strategyName, $expected);
        $this->assertEquals($expected, $result);

        $expected = '345';
        $data     = [
            $strategyName => $expected,
        ];
        $this->object->setRendererToStrategy($data);
        $result   = $this->object->getStrategyNameForRenderer($strategyName);
        $this->assertEquals($expected, $result);
    }

    /**
     * @covers ::addRendererToStrategy
     */
    public function testAddRendererToStrategy(): void
    {
        $value = $this->object->addRendererToStrategy('a', 'b');
        $this->assertNull($value);
    }

    /**
     * @covers ::getUmask
     * @covers ::setUmask
     */
    public function testUmask(): void
    {
        $this->assertNull($this->object->getUmask());
        $this->object->setUmask(0666);
        $this->assertSame(0666, $this->object->getUmask());
        $this->object->setUmask(null);
        $this->assertNull($this->object->getUmask());
    }

    /**
     * @covers ::getAcceptableErrors
     * @covers ::setAcceptableErrors
     */
    public function testAcceptableErrors(): void
    {
        $this->assertEmpty($this->object->getAcceptableErrors());
        $this->object->setAcceptableErrors([1 => 2, 3 => 4]);
        $this->assertSame([1 => 2, 3 => 4], $this->object->getAcceptableErrors());
    }

    /**
     * @covers ::__construct
     * @covers ::processArray
     * @covers ::assembleSetterNameFromConfigKey
     */
    public function testPassingOptionsByConstructor(): void
    {
        $this->assertTrue($this->object->isDebug());
        $this->assertTrue($this->object->getBuildOnRequest());

        $config1            = new \ArrayObject();
        $config1['debug']   = true;
        $config1['combine'] = true;

        $newObject1 = new AsseticBundle\Configuration($config1);
        $this->assertTrue($newObject1->isDebug());
        $this->assertTrue($newObject1->isCombine());
    }

    /**
     * @covers ::__construct
     * @covers ::processArray
     * @covers ::assembleSetterNameFromConfigKey
     */
    public function testPassingInvalidOptionsByConstructor(): void
    {
        $this->expectException(AsseticBundle\Exception\BadMethodCallException::class);
        $config2             = new \ArrayObject();
        $config2['debug']    = true;
        $config2['noExists'] = true;

        $newObject2 = new AsseticBundle\Configuration($config2);
        $this->assertTrue($newObject2->isDebug());
        $this->assertTrue($newObject2->isCombine());
    }

    /**
     * @covers ::getBuildOnRequest
     * @covers ::setBuildOnRequest
     */
    public function testBuildOnRequest(): void
    {
        $this->assertTrue($this->object->getBuildOnRequest());
        $this->object->setBuildOnRequest(false);
        $this->assertFalse($this->object->getBuildOnRequest());
    }

    /**
     * @covers ::setWriteIfChanged
     * @covers ::getWriteIfChanged
     */
    public function testWriteIfChanged(): void
    {
        $this->assertTrue($this->object->getBuildOnRequest());
        $this->object->setWriteIfChanged(false);
        $this->assertFalse($this->object->getWriteIfChanged());
    }

    /**
     * @covers ::detectBaseUrl
     */
    public function testDetectBaseUrl(): void
    {
        $this->assertTrue($this->object->detectBaseUrl());
        $this->object->setBaseUrl('auto');
        $this->assertTrue($this->object->detectBaseUrl());
        $this->object->setBaseUrl('test');
        $this->assertFalse($this->object->detectBaseUrl());
    }

}
