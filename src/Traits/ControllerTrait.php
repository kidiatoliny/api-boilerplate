<?php

namespace Akira\ResourceBoilerplate\Traits;

use Illuminate\Support\Str;

use Illuminate\Container\Container;

trait ControllerTrait
{

    protected function isControllerPathExist()
    {
        $model = ucfirst(Str::camel($this->argument('model')));
        $controllerName = $model . 'Controller';
        $path = app_path('Http\Controllers\\' . $controllerName . '.php');

        if ($this->files->exists($path)) {
            return true;
        }
        return false;
    }

    protected function getControllerName()
    {
        $model = ucfirst(Str::camel($this->argument('model')));
        return   $model . 'Controller';
    }

    protected function controllerExist()
    {
        $this->error('Controller ' . $this->getControllerName() . ' already exists');
    }

    protected function makeController()
    {
        $this->files->put(
            base_path('/app/Http/Controllers/' . $this->getControllerName() . '.php'),
            $this->compileControllerStub()
        );
        $this->info('Controller ' . $this->getControllerName() . ' created');
    }
}
