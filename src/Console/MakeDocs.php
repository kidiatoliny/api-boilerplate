<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


use Illuminate\Support\Facades\Artisan;
use Akira\ResourceBoilerplate\Traits\ModelTrait;
use Akira\ResourceBoilerplate\Traits\CommonTrait;

class MakeDocs extends Command
{

    use CommonTrait;
    use ModelTrait;
    protected $signature = 'akira:docs';

    protected $description = 'Create a new Api documentation';

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
        Artisan::call('vendor:publish --tag=idoc-config');
    }
}
