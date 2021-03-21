<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Akira\ResourceBoilerplate\Traits\CreateAndUpdateFiles;
use Akira\ResourceBoilerplate\Traits\ValidateMakeRouteConsoleInput;

class MakeModelRoute extends Command
{

    use ValidateMakeRouteConsoleInput;
    use CreateAndUpdateFiles;

    protected $signature = 'akira:model-route {model : class name} {resourcefully-action : index, show, edit, update, create, store, destroy}';

    protected $description = 'Create a new model route with controller method';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;
    private $baseModel;
    private $resourcefullyAction;
    private $controllerName;

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
        $this->baseModel = trim($this->argument('model'));
        if (!$this->isValidModelInput()) {
            return;
        }
        $this->resourcefullyAction = trim($this->argument('resourcefully-action'));
        if (!$this->isValidResourcefullyAction()) {
            return;
        }
        if (!$this->appendRoute()) {
            return;
        }
        $controllerName = Str::studly($this->baseModel) . 'Controller';
        $controllerUpdated = $this->createOrUpdateController();
        $this->createModelIfDoesNotExist();
        if ($controllerUpdated) {
            $this->createModelView(app_path('Http/Controllers/' . $controllerName . '.php'));
        }
        $this->generateModelTest();
    }

    private function appendRoute()
    {
        $controllerName = '\\App\\Http\\Controllers\\' . Str::studly($this->baseModel) . 'Controller';
        $baseSlug = Str::slug(Str::snake(Str::plural($this->baseModel)));
        $slug = $this->generateModelSlug($baseSlug);
        return $this->appendRouteToRoutesFile($slug, $controllerName);
    }

    private function generateModelSlug($baseSlug)
    {
        switch ($this->resourcefullyAction) {
            case 'index':
            case 'store':
                return $baseSlug;
                break;
            case 'create':
                return $baseSlug . '/create';
                break;
            case 'show':
            case 'update':
            case 'destroy':
                return $baseSlug . '/{' . Str::camel($this->baseModel) . '}';
                break;
            case 'edit':
                return $baseSlug . '/{' . Str::camel($this->baseModel) . '}/edit';
                break;
        }
    }
}
