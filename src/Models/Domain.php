<?php

namespace WeDevelopCoffee\wPower\Models;

use WHMCS\Domain\Domain as BaseDomain;
use WHMCS\Database\Capsule;

/**
 * Class Domain
 * @package WeDevelopCoffee\wPower\Models
 */
class Domain extends BaseDomain
{
    public $customQueryObject;

    /**
     * Get the handles for this domain.
     */
    public function handles()
    {
        return $this->belongsToMany('WeDevelopCoffee\wPower\Handles\Models\Handle','wDomain_handle');
    }

    /**
     * Update the offset for the next due date based on the expiry date.
     *
     * @param int $days
     * @return array
     */
    public function updateNextDueDateOffset($days = 40, $queryBuilder = null)
    {
        if($queryBuilder == null)
            $queryObject = $this;
        else
            $queryObject = $queryBuilder;

        // Select the domains with the wrong offset.

        $domains = $queryObject->selectRaw('@new_nextduedate := DATE_SUB(`expirydate`, INTERVAL ? DAY) `new_nextduedate`, DATEDIFF(@new_nextduedate, `nextduedate`) `new_nextduedate_difference`, tbldomains.*', [$days])
        ->whereRaw('tbldomains.nextduedate !=  DATE_SUB(`expirydate`, INTERVAL ? DAY)', [$days])
            ->whereRaw('@new_nextduedate_difference >= ?', [($days * -1)])
            ->whereRaw('@new_nextduedate_difference <= ?', [$days])
            ->get();

        $updated_domains = [];
        
        foreach($domains as $domain)
        {
            $original_nextduedate = $domain->nextduedate;
            $domain->nextduedate = $domain->new_nextduedate;
            $domain->nextinvoicedate = $domain->new_nextduedate;
            $domain->save();

            // Update the invoice item if there was any.
            Capsule::table('tblinvoiceitems')
                ->where('type', 'domain')
                ->where('relid', $domain->id)
                ->where('duedate', $original_nextduedate)
                ->update(['duedate' =>  $domain->nextduedate]);

            $updated_domains[] = [ 'domain' => $domain, 'original_nextduedate' => $original_nextduedate];
        }

        return $updated_domains;
    }
}