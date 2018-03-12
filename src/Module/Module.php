<?php
namespace WeDevelopCoffee\wPower\Module;
use WeDevelopCoffee\wPower\Core\Core;
use WeDevelopCoffee\wPower\Core\Path;

/**
 * Module functions
 */
class Module {
    /**
     * The found type.
     *
     * @var string
     */
    protected $type = 'unknown';

    /**
     * The found name of the module.
     *
     * @var string
     */
    protected $name;

    /**
     * The Core
     *
     * @var object
     */
    protected $core;

    /**
     * The Path
     *
     * @var object
     */
    protected $path;

    /**
     * Run the checks
     */
    public function __construct(Core $core)
    {
        $this->core = $core;

        $this->cli = $core->isCli();

        $this->checkAddon();
            
        $this->checkGateway();
        
        $this->checkRegistrar();
        
        $this->checkServer();
    }

    /**
     * Check if this is an addon.
     *
     * @return boolean
     */
    public function checkAddon()
    {
        // Determine based on the hooks. This should always happen first.
        // @todo
        if($this->name = $this->getModuleName('addons'))
            $this->type = 'addon';
        
        return false;
    }

    public function checkGateway() {}

    public function checkRegistrar() {}

    public function checkServer() {}

    

    /**
     * Backtraces the code execution to find the module name
     *
     * @param string $type the type formatted as WHMCS directory (like addons)
     * @return void
     */
    protected function getModuleName($type)
    {
        $backtrace = debug_backtrace();

        // Loop through every backtrace
        foreach($backtrace as $trace)
        {
            if(isset($trace['file'])
            // Ignore wPower files
            && strpos($trace['file'], 'wPower/src') === false
            // Only module files are allowed.
            && strpos($trace['file'], 'modules') == true)
            {
                // dd('/\/modules\/'.$type.'\/([a-zA-Z0-9-_]+)\//');
                $expression = '/\/modules\/'.$type.'\/([a-zA-Z0-9-_]+)\//';
                preg_match($expression, $trace['file'], $matches);
            
                return $matches [1];
            }
        }

        return false;
    }

    /**
     * Return the module it's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return the module type
     *
     * @return string addon|gateway|registrar|server|unknown
     */
    public function getType()
    {
        return $this->type;
    }
}

