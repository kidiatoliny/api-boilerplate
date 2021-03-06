<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Console\Command;

use Illuminate\Filesystem\Filesystem;


use Akira\ResourceBoilerplate\Traits\ModelTrait;
use Akira\ResourceBoilerplate\Traits\CommonTrait;


class MakeModel extends Command
{
    use CommonTrait;
    use ModelTrait;

    protected $signature = 'akira:model {model}';

    protected $description = 'Create a new Model';

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
            if ($this->isModelPathExist()) {
                $this->modelExist();
            } else {
                $this->makeModel();
            }
        }
    }
}
