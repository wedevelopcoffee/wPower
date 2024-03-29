<?php

namespace WeDevelopCoffee\wPower\Core;

/**
 * Class Instance
 */
class Instance
{
    /**
     * @var Core
     */
    private $core;

    public function __construct(Core $core)
    {

        $this->core = $core;
    }

    /**
     * Create the controller.
     */
    public function createInstance($class)
    {
        $launchClass = $this->core->getNamespace().'\\Controllers\\'.ucfirst($this->core->getLevel()).'\\'.$class;
        if (! class_exists($launchClass)) {
            $launchClass = $class;
        }

        $this->instance = $this->core->launcher->get($launchClass);

        return $this->instance;
    }

    /**
     * Execute the method in the instance.
     */
    public function execute($method, $params)
    {
        return $this->instance->$method($params);
    }
}
