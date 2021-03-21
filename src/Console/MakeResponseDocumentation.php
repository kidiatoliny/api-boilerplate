<?php

namespace Akira\ResourceBoilerplate\Console;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Akira\ResourceBoilerplate\Traits\ResponsesTrait;




class MakeResponseDocumentation extends Command
{

    use ResponsesTrait;


    protected $signature = 'akira:responses {model}';

    protected $description = 'Create a new Api response documentation';

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
        $this->model = $this->argument('model');

        if ($this->model) {
            $this->createPathsIfIsNoExists();
        }
        //  dd($this->compileResponseStub());
        $this->makeResposes();
    }
}
