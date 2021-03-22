<?php


namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Console\Command;

use Illuminate\Filesystem\Filesystem;



use Akira\ResourceBoilerplate\Traits\RouteTrait;



class MakeRoute extends Command
{

    use RouteTrait;

    protected $signature = 'akira:route {model}';

    protected $description = 'Create a new Api route';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;
    private $model;



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

        if ($this->argument('model')) {
            $this->compileRouteStub();
            $this->apiRoutesAppended();
        }
    }
}
