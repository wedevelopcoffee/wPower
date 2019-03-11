<?php

namespace WeDevelopCoffee\wPower\Module;

use Illuminate\Database\Migrations\Migrator;
use WeDevelopCoffee\wPower\Core\Core;
use WeDevelopCoffee\wPower\Core\Path;

/**
 * Class Setup
 * @package WeDevelopCoffee\wPower\Module
 */
class Setup
{
    /**
     * @var Migrator
     */
    private $migrator;

    /**
     * @var migration paths
     */
    private $migrationPaths;

    public function __construct(Migrator $migrator, Path $path)
    {

        $this->migrator = $migrator;
        $this->path = $path;
    }

    public function activate()
    {
        $this->findModuleMigrationPath();
        $this->migrate();
    }

    public function deactivate()
    {
        $this->findModuleMigrationPath();
        $this->migrate('reset');
    }

    public function upgrade()
    {
        $this->findModuleMigrationPath();
        $this->migrate('upgrade');
    }

    /**
     * Migrate!
     *
     * @return array
     */
    public function migrate ($action = 'run')
    {
        // Check if the repository exists.
        if(!$this->migrator->repositoryExists())
        {
            // Let's create the repository.
            $repository = $this->migrator->getRepository();
            $repository->createRepository();
        }

        if(!empty($this->migrationPaths))
        {
            foreach($this->migrationPaths as $path)
            {
                if($action == 'run')
                    $this->migrator->run($path);
                elseif($action == 'reset')
                {
                    $files = $this->migrator->getMigrationFiles($path);
                    $this->migrator->requireFiles($path, $files);
                    $this->migrator->reset();
                }
            }
        }

        return true;
    }

    /**
     * Find the migration path for the module.
     */
    protected function findModuleMigrationPath()
    {
        $migrationPath = $this->path->getModuleMigrationPath();

        if (is_dir($migrationPath)) {
            $this->migrationPaths [] = $migrationPath;
        }
    }
}