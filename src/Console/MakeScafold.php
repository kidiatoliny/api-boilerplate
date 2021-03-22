<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Akira\ResourceBoilerplate\Traits\ModelTrait;
use Akira\ResourceBoilerplate\Traits\CommonTrait;
use Akira\ResourceBoilerplate\Traits\ControllerTrait;


class MakeScafold extends Command
{
    use ModelTrait;
    use CommonTrait;
    use ControllerTrait;

    protected $signature = 'akira:scafold {model}';

    protected $description = 'Create a new API model Scafold';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;
    private $modelname;



    /**
     * Create a new command instance.
     *
     * @param  Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $this->modelname = $this->argument('model');
        $command =  ucfirst($this->modelname);

        $migrationName = 'create_' . $this->tableName() . '_table';

        $this->info('Creating resources from the  ' . $this->getModelName() . '...');

        Artisan::call('akira:model ' . $command);
        $this->info('Model ' . $this->getModelName() . ' created ...');

        Artisan::call('akira:controller ' . $command);
        $this->info('Controller ' . $this->getControllerName() . ' created ...');

        Artisan::call('akira:route ' . $command);
        $this->info('Routes ' . $this->tableName() . ' created ...');

        Artisan::call('akira:responses ' . $command);
        $this->info('Responses Docs ' . $this->tableName() . ' created ...');

        Artisan::call('make:resource ' . $command . 'Resource');
        $this->info('Resource ' . $this->getModelName() . 'Resource' . ' created ...');
        Artisan::call('make:migration ' . $migrationName);
        $this->info('Migration ' . $migrationName . ' created ...');

        $this->info('All done 👌 !!!');
    }
}
