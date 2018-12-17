<?php
namespace Tests\Controllers;
use Mockery;
use Tests\TestCase;
use WeDevelopCoffee\wPower\Controllers\Dispatcher;
use WeDevelopCoffee\wPower\Core\Core;
use WeDevelopCoffee\wPower\Core\Router;
use WeDevelopCoffee\wPower\Module\Module;

class Base extends TestCase
{
    protected $level;
    protected $dispatcherClass = Dispatcher::class;

    protected $dispatcher;
    protected $mockedCore;
    protected $mockedRouter;
    protected $mockedModule;

    /**
     * Sample settings
     */

    protected $moduleType = 'registrar';
    protected $moduleName = 'wPowerModule';
    protected $moduleNamespace = '\Tests\dependencies';

    /**
     * setUp
     *
     */
    public function setUp ()
    {
        //Test\dependencies\Controllers;
        // Set globals
        $GLOBALS['wAutoloader'][$this->moduleType][$this->moduleName]['namespace'] = $this->moduleNamespace;
        
        // Mock the core
        $this->mockedCore   = Mockery::mock(Core::class);
        $this->mockedCore->shouldReceive('setLevel')
            ->with($this->level)
            ->once();


        // Mock the router
        $this->mockedRouter = Mockery::mock(Router::class);
        $this->mockedRouter->shouldreceive('getRoutes')
            ->once()
            ->andReturn($this->routes);

        // Mock the module
        $this->mockedModule = Mockery::mock(Module::class);

        $dispatcher = (string) $this->dispatcherClass;
        $this->dispatcher = new $dispatcher($this->mockedCore, $this->mockedRouter, $this->mockedModule);
    }


}