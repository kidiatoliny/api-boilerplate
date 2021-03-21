<?php

namespace Akira\ResourceBoilerplate\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use  Akira\ResourceBoilerplate\Traits\CreateAndUpdateFiles;
use  Akira\ResourceBoilerplate\Traits\ValidateMakeRouteConsoleInput;

class MakeRoute extends Command
{

    use ValidateMakeRouteConsoleInput;
    use CreateAndUpdateFiles;

    protected $signature = 'akira:route {slug : kebab case relative path} {resourceful-action : index, show, edit, update, create, store, destroy} {controller-name? : If you do not define a controller path, one will be generated based on your slug}';

    protected $description = 'Create a new route with controller, view and basic test';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;
    private $slug;
    private $resourcefullyAction;
    private $baseModel = null;
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
        $this->validateMakeRouteInputs();

        if (!$this->appendRouteToRoutesFile($this->slug, '\\App\\Http\\Controllers\\' . $this->controllerName)) {
            return;
        }
        $controllerUpdate = $this->createOrUpdateController($this->controllerName);
        if ($controllerUpdate) {
            $this->createView(app_path('Http/Controllers/' . $this->controllerName . '.php'));
        }
        $this->generateTest();
    }

    private function validateMakeRouteInputs()
    {
        $this->slug = ltrim(strtolower(trim($this->argument('slug'))), '/');
        if (!$this->isSlugKebabCase($this->slug)) {
            $this->error('Your slug, "' . $this->slug . '" is not in kebab case. Please try again');

            return;
        }
        if ($this->argument('controller-name')) {
            $this->controllerName = $this->argument('controller-name');
        } else {
            $controllerName = rtrim(str_replace("-", " ", preg_replace('/{(.*?)}/', '', $this->slug)), '/');
            $controllerName = str_replace('/', " ", $controllerName);
            $controllerName = str_replace("_", " ", $controllerName);
            $controllerName = ucwords($controllerName);
            $controllerName = str_replace(" ", "", $controllerName);
            $this->controllerName = $controllerName . 'Controller';
        }
        $this->resourcefullyAction = trim($this->argument('resourcefully-action'));
        if (!$this->isValidResourcefullyAction()) {
            $this->error('You did not enter a valid resourcefully action');

            return;
        }
    }
}
