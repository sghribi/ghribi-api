<?php

namespace Ghribi\Features\Services;

require_once(__DIR__ . '../../../../../app/AppKernel.php');

use \AppKernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Prophecy\PhpUnit\ProphecyTestCase;

/**
 * Class AbstractServiceTest
 */
abstract class AbstractServiceTest extends ProphecyTestCase
{
    /**
     * @var AppKernel
     */
    protected $kernel;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Set up a new Kernel
     */
    protected function setUp()
    {
        parent::setUp();

        // Boot the AppKernel in the test environment and with the debug.
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        // Store the container in test case properties
        $this->container = $this->kernel->getContainer();
    }

    /**
     * @return array
     */
    abstract public function provideServices();

    /**
     * Test good injection
     *
     * @param string $serviceName
     * @param string $serviceClass
     *
     * @dataProvider provideServices
     */
    public function testGoodInjectionInServices($serviceName, $serviceClass)
    {
        $this->setUp();

        $service = $this->container->get($serviceName);
        $this->assertInstanceOf($serviceClass, $service);
    }
}
