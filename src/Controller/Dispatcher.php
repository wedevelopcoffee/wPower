<?php
namespace WeDevelopCoffee\wPower\Controller;
use WeDevelopCoffee\wPower\Core\Core;
use WeDevelopCoffee\wPower\Core\Router;


/**
 * Controller dispatcher
 */
class Dispatcher
{
    /**
     * All the routers
     * 
     * @param array
     */
    protected $routes;

    /**
     * The router instance
     *
     * @var object
     */
    protected $router;
    
    /**
     * The requested action.
     *
     * @var string
     */
    protected $action;

    /**
     * Define the user level
     *
     * @var string
     */
    protected $level = 'hooks';

    /**
     * Core
     *
     * @var object
     */
    protected $core;

    /**
     * Constructor
     */
    public function __construct(Core $core, Router $router)
    {
        $this->core = $core;
        $this->core->setLevel($this->level);

        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /**
     * Dispatch request.
     *
     * @param string $action
     * @param array $parameters
     *
     * @return string
     */
    public function dispatch($action, $parameters)
    {
        if($action == '')
            $action = 'index';


        $this->action = $action;

        $controllerNameAndFunction = $this->getControllerNameAndFunction();

        $controller = $this->getController($controllerNameAndFunction['controller']);
        
        $launch_controller = new $controller();

        return $launch_controller->$controllerNameAndFunction['function']();
    }

    /**
     * Try to find the expected controller.
     *
     * @return void
     */
    protected function getController($controller)
    {
        $regex = '/([a-zA-Z0-9_]*)$/A';
        
        preg_match($regex, $controller, $matches);
        
        // Print the entire match result
        if(!isset($matches[0]) || $matches[0] == '')
        {
            // It is an exact path
            return $controller;
        }
        else
        {
            $namespace = $this->getExpectedNameSpace();
            return $namespace . '\\' . $controller;
        }
    }

    /**
     * Get the controller name and function
     *
     * @return void
     */
    protected function getControllerNameAndFunction($key = null)
    {
        if($key === null)
            $key = $this->action;

        if(!$rawController = $this->routes[$key])
        {
            throw new \Exception ('NOT FOUND');
        }
            

        if($this->level == 'hooks')
            $rawController = $rawController['controller'];

        $rawController = explode('@', $rawController);

        $controller = $rawController[0];

        if(isset($rawController[1]))
            $function = $rawController[1];
        else
        {
            $function = 'index';
        }

        return ['controller' => $controller, 'function' => $function];
    }

    /**
     * Get the expected namespace
     *
     * @return string The namespace
     */
    protected function getExpectedNameSpace()
    {
        $included_files = get_included_files();

        $included_files = array_reverse($included_files);

        foreach($included_files as $included_file)
        {
            $re = '/\/([a-zA-Z0-9_-]*)/';

            preg_match_all($re, $included_file, $matches, PREG_SET_ORDER, 0);

            end($matches);
            $key = key($matches);

            $secondKey = $key - 1;
            $thirdKey = $secondKey - 1;
            $fourthKey = $thirdKey - 1;
            
            if($matches[$key][1] == $matches[$secondKey][1] && $matches[$thirdKey][1] == 'addons')
            {
                $module = $matches[$secondKey][1];

                if($this->level == 'admin')
                    return $GLOBALS['wAutoloader'][$module]['namespace'] . '\Controllers\Admin';
                elseif($this->level == 'client')
                    return $GLOBALS['wAutoloader'][$module]['namespace'] . '\Controllers\Client';
                
            }
            elseif ($matches[$key][1] == 'hooks' && $matches[$fourthKey][1] == 'addons' && $this->level == 'hooks')
            {
                $module = $matches[$thirdKey][1];

                return $GLOBALS['wAutoloader'][$module]['namespace'] . '\Controllers\Hooks';
            }
        }
    }
}
