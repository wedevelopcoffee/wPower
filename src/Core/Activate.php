<?php
namespace WeDevelopCoffee\wPower\Core;

use Illuminate\Database\Migrations\Migrator;

class Activate
{

    /**
     * @Illuminate\Database\Migrations\Migrator
     *
     * @var object
     */
    protected $migrator;

    /**
     * Array with paths to specific migrations.
     *
     * @var array
     */
    protected $migrationPaths;

    /**
    * Constructor
    *  
    */
    public function __construct ( Migrator $migrator)
    {
        $this->migrator = $migrator;
    }

    /**
    * Enable the features for database migrations
    * 
    * @return void
    */
    public function enableFeature ($features)
    {
        if($feature == 'handles')
            $this->addFeatureMigrationPath('Handles');

        return $this;
    }

    /**
    * Add path to the list of migration paths
    * 
    * @return void
    */
    public function addMigrationPath ($path)
    {
        $this->migrationPaths[] = $path;

        return $this;
    }

    /**
    * Migrate!
    * 
    * @return array
    */
    public function Migrate ()
    {
        return $this->migrator->run($this->migrationPaths);
    }

    /**
    * Generate the addon path
    * 
    */
    protected function addFeatureMigrationPath ($feature)
    {
        $path = dirname(__FILE__) . '/../' . $feature . '/migrations/';
        $this->addMigrationPath($path);
    }
}
