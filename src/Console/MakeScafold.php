<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;


class MakeScafold extends Command
{

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

        $migration = 'create_' . Str::snake(Str::plural($this->modelname)) . '_table';

        Artisan::call('akira:model ' . $command);
        Artisan::call('akira:controller ' . $command);
        Artisan::call('akira:responses ' . $command);
        Artisan::call('make:resource ' . $command . 'Resource');
        Artisan::call('make:migration ' . $migration);
    }
}
