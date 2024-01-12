<?php

namespace WeDevelopCoffee\wPower\Tests\Core;

use WeDevelopCoffee\wPower\Core\API;
use WeDevelopCoffee\wPower\Tests\TestCase;

class ApiTest extends TestCase
{
    protected $api;

    public function test_api()
    {
        $command = 'testCommand';
        $value = ['some-value'];
        $adminuser = 'admin';

        $result = $this->api->exec($command, $value, $adminuser);

        $expectedResult = [
            $command,
            $value,
            $adminuser,
        ];

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * setUp
     */
    public function setUp(): void
    {
        $this->api = new API();
    }
}
