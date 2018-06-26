<?php
namespace WeDevelopCoffee\wPower\Models;

/**
 * Handle system
 */
class Domain extends \WHMCS\Domain\Domain {

    public function __construct(wPower\Core\API)
    {
        
    }

    /**
     * Get the handles for this domain.
     */
    public function handles()
    {
        return $this->belongsToMany('WeDevelopCoffee\wPower\Models\Handle','wDomain_handle');
    }
}

