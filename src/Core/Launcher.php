<?php
namespace WeDevelopCoffee\wPower\Core;

use ReflectionClass;

class Launcher
{
    protected $map = [
        '\Illuminate\Database\Migrations\MigrationRepositoryInterface' => \Illuminate\Database\Migrations\DatabaseMigrationRepository::class,
        '\Illuminate\Database\ConnectionResolverInterface' => \Illuminate\Database\Connection::class
    ];


    /**
    *  Launch a class
    * 
    * Also performs automatic dependency injection for a class.
    * 
    * @param  string  $view
    * @param  array   $data
    * @return object
    */
    public function launchClass ($class)
    {
        if($class == 'WeDevelopCoffee\wPower\wPower' && isset($GLOBALS['wPower']))
        {
            // Exists!
            return $GLOBALS['wPower'];
        }

        $class = $this->mapClass($class);

        $reflect = new ReflectionClass($class);
        
        try
        {
            $reflectmethod  = $reflect->getMethod('__construct');

            // Check for extra parameters
            if(count(func_get_args()) > 1)
            {
                $extra_arg = func_get_args();
                unset($extra_arg[0]);
                $extra_arg_next = 1;
            }

            if(count($reflectmethod->getParameters()) != 0)
            {
                $params = [];
                foreach($reflectmethod->getParameters() as $num => $param) {
                    if ($param->getClass()) {

                        $className = $param->getClass()->name;                            

                        $params[] = $this->launchClass($className);
                    }
                    else
                    {
                        // Check if we have received an extra argument that we can pass on.
                        if(isset($extra_arg[$extra_arg_next]))
                        {
                            $params[] = $extra_arg[$extra_arg_next];
                            $extra_arg_next++; // Increase the count for the next argument.
                        }    
                    }
                }
                
                $instance = $reflect->newInstanceArgs($params);
            }
            else
                $instance = new $class();
        }
        catch ( \ReflectionException $e)
        {
            // There is no constructor.
            $instance = new $class();
        }

        if($class == 'WeDevelopCoffee\wPower\wPower')
            $GLOBALS['wPower'] = $instance;
        
        return $instance;
    }

    /**
    * Convert interface/class to a mapped class
    * 
    * @return string $class
    */
    protected function mapClass ($class)
    {
        if(isset($this->map[$class]))
            return $this->map[$class];
        
        if(isset($this->map['\\'.$class]))
            return $this->map['\\'.$class];
        
        return $class;
    }
}
