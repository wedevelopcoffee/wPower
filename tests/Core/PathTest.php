<?php

namespace WeDevelopCoffee\wPower\Tests\Core;

use Mockery;
use WeDevelopCoffee\wPower\Core\Core;
use WeDevelopCoffee\wPower\Core\Path;
use WeDevelopCoffee\wPower\Tests\TestCase;

/**
 * Class PathTest
 */
class PathTest extends TestCase
{
    protected $path;

    protected $mockedCore;

    protected $mockedModule;

    public function test_get_doc_root()
    {
        $result = $this->path->getDocRoot();

        $this->assertStringContainsString(getcwd(), $result);
    }

    public function test_get_addons_path()
    {
        $result = $this->path->getAddonsPath();

        // Overriding __DIR__ is tricky, instead we have to rely on that this works.

        $this->assertStringContainsString('modules/addons/', $result);
    }

    public function test_get_module_path()
    {
        $moduleName = 'some-module';

        $this->mockedCore->shouldReceive('getModuleName')
            ->once()
            ->andReturn($moduleName);

        $this->mockedCore->shouldReceive('getModuleType')
            ->once()
            ->andReturn('addon');

        $result = $this->path->getModulePath();

        // Overriding __DIR__ is tricky, instead we have to rely on that this works.

        $this->assertStringContainsString('modules/addons/'.$moduleName.'/', $result);
    }

    public function test_get_addon_migration_path()
    {
        $moduleName = 'some-module';

        $this->mockedCore->shouldReceive('getModuleName')
            ->once()
            ->andReturn($moduleName);

        $this->mockedCore->shouldReceive('getModuleType')
            ->once()
            ->andReturn('addon');

        $result = $this->path->getModuleMigrationPath();

        $this->assertStringContainsString('modules/addons/'.$moduleName.'/migrations/', $result);
    }

    /**
     * setUp
     */
    public function setUp(): void
    {
        $this->mockedCore = Mockery::mock(Core::class);
        $this->path = new Path($this->mockedCore);

        $this->mockedCore->shouldReceive('isCli')
            ->once()
            ->andReturn(true);
    }
}
