<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;


use Illuminate\Filesystem\Filesystem;
use Akira\ResourceBoilerplate\Traits\Scafold;
use Akira\ResourceBoilerplate\Traits\ControllerTrait;

class MakeController extends Command
{
    use Scafold;
    use ControllerTrait;

    protected $signature = 'akira:controller {model}';

    protected $description = 'Create a new API controller';

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
            if ($this->isControllerPathExist()) {
                $this->controllerExist();
            } else {
                $this->makeController();
            }
        }
    }
}
