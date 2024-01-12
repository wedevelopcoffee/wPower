<?php

namespace WeDevelopCoffee\wPower\Handles\Exception;

use Exception;

/**
 * The handle is in use by multiple domains. Instead of updating, a new
 * handle is required.
 */
class HandleUsedByMultipleDomains extends Exception
{
}
