<?php

namespace WeDevelopCoffee\wPower\Core;

/**
 * Class Hooks
 */
class Hooks
{
    /**
     * Simple wrapper for adding a hook to WHMCS.
     */
    public function add_hook($hookPoint, $priority, $function)
    {
        \add_hook($hookPoint, $priority, $function);
    }
}
