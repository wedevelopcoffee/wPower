<?php

namespace WeDevelopCoffee\wPower\Controllers;

use WeDevelopCoffee\wPower\Core\Core;

/**
 * Controller dispatcher
 */
class BaseController
{
    /**
     * @var Core
     */
    protected $core;

    /**
     * ViewBaseController constructor.
     */
    public function __construct(Core $core)
    {
        $this->core = $core;
    }
}
