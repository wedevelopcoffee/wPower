<?php

namespace WeDevelopCoffee\wPower\Tests;

use PHPUnit\Framework\TestCase as baseTestCase;

class TestCase extends baseTestCase
{
    /**
     * @var array All testdata.
     */
    protected $testData = [
        'namespace' => 'WeDevelopCoffee\internaldomaintransfer',
        'moduleType' => 'addon',
        'moduleName' => 'internaldomaintransfer',
        'level' => 'admin',

        // URLS
        'baseUrl' => 'http://dev.domain.com/',
        'adminAddonUrl' => 'http://dev.domain.com/admin/addonmodules.php',
        'adminUrl' => 'http://dev.domain.com/custom-admin-folder/',
        'addonUrl' => 'http://dev.domain.com/modules/addons/internaldomaintransfer/',

        'customAdminFolder' => 'custom-admin-folder',

        // Routes
        'hookRoutes' => [
            'some-hook-point' => [
                'hookPoint' => 'SomeWhmcsHookPoint',
                'priority' => 1,
                'controller' => 'HookController@some',
            ],
            'index' => [
                'hookPoint' => 'indexWhmcsHookPoint',
                'priority' => 1,
                'controller' => 'HookController@index',
            ],
        ],

    ];

    /**
     * Run Mockery.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        \Mockery::close();
    }
}
