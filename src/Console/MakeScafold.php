<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


use Illuminate\Support\Facades\Artisan;
use Akira\ResourceBoilerplate\Traits\Scafold;

class MakeScafold extends Command
{

    use Scafold;

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
        $command =  $this->modelname;

        Artisan::call('akira:controller ' . $command);
        Artisan::call('akira:model ' . $command);
    }
}
