<?php

namespace Akira\ResourceBoilerplate\Traits;

use Illuminate\Support\Str;

use Illuminate\Container\Container;

trait ModelTrait
{

    protected function isModelPathExist()
    {
        $model = ucfirst(Str::camel($this->argument('model')));

        $path = app_path('Models\\' .  $model . '.php');

        if ($this->files->exists($path)) {
            return true;
        }
        return false;
    }

    protected function getModelName()
    {
        $model = ucfirst(Str::camel($this->argument('model')));
        return   $model;
    }

    protected function modelExist()
    {
        $this->error('Model ' . $this->getModelName() . ' already exists');
    }

    protected function makeModel()
    {
        $this->files->put(
            base_path('/app/Models/' . $this->getModelName() . '.php'),
            $this->compileControllerStub()
        );
        $this->info('Model ' . $this->getModelName() . ' created');
    }
}
