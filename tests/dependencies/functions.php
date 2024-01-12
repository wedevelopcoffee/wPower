<?php

/**
 * Mimic WHMCS globals functions
 */
function add_hook($hookPoint, $priority, $function)
{
    // Store in globals for testing purposes.
    $GLOBALS['test']['add_hook'][] = [
        'hookPoint' => $hookPoint,
        'priority' => $priority,
        'function' => $function,
    ];
}

/**
 * Mimic WHMCS localAPI
 *
 * @return array
 */
function localAPI($command, $values, $adminuser = null)
{
    return [
        $command,
        $values,
        $adminuser,
    ];
}
