<?php

namespace WeDevelopCoffee\wPower\Models;

use WHMCS\Mail\Template;

/**
 * Class EmailTemplate
 * @package WeDevelopCoffee\wPower\Models
 */
class EmailTemplate extends Template
{
    /**
     * Filter on $type.
     *
     * @param $type
     * @return object $this
     */
    public function filterOnType($type)
    {
        return self::where('type', $type);
    }
}