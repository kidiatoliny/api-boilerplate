<?php

namespace Akira\ResourceBoilerplate\Traits;

use Illuminate\Support\Str;
use Akira\ResourceBoilerplate\Traits\ModelTrait;
use Akira\ResourceBoilerplate\Traits\CommonTrait;
use Akira\ResourceBoilerplate\Traits\ResponsesTrait;

trait ControllerTrait
{
    use CommonTrait;
    use ModelTrait;
    use ResponsesTrait;



    protected function controllerBaseNameSpace()
    {
        return  'Http\Controllers';
    }

    protected function controllerBasePath()
    {
        return app_path('Http\Controllers\\');
    }

    protected function controllerUseStatement()
    {
        return 'use ' . $this->controllerNameSpace() . ';';
    }
    protected function controllerNameSpace()
    {
        return $this->getAppNameSpace() . $this->controllerBaseNameSpace() . '\\' . $this->getControllerName();
    }

    protected function controllerPath()
    {
        return $this->controllerBasePath() . $this->getControllerName() . '.php';
    }

    protected function isControllerPathExist()
    {
        if ($this->files->exists($this->controllerPath())) {
            return true;
        }
        return false;
    }


    protected function getControllerName()
    {
        return   $this->getModelName() . 'Controller';
    }

    protected function controllerExist()
    {
        $this->error('Controller ' . $this->getControllerName() . ' already exists');
    }


    protected function replaceNameSpacedModel(&$stub)
    {
        $variable = $this->stubVariable('namespacedModel');
        $value = $this->getAppNameSpace() . $this->modelNameSpace();
        $stub = str_replace($variable, $value, $stub);
        return $this;
    }

    /**
     * Replace Model Name
     *
     * @param [stub] $stub
     * @return modelName
     */
    protected function replaceModel(&$stub)
    {
        $variable = $this->stubVariable('model');
        $value = $this->getModelName();
        $stub = str_replace($variable, $value, $stub);
        return $this;
    }

    /**
     * Replacem Model Variable
     *
     * @param [type] $stub
     * @return modelVariable
     */
    protected function replaceModelVariable(&$stub)
    {
        $value = Str::lower($this->getModelName());
        $variable = $this->stubVariable('modelVariable');
        $stub = str_replace($variable, $value, $stub);
        return $this;
    }


    protected function replaceResponsePath(&$stub)
    {
        $value = $this->responsePathName();
        $variable = $this->stubVariable('responsepath');
        $stub = str_replace($variable, $value, $stub);
        return $this;
    }
    protected function compileControllerStub()
    {
        $stub = $this->getStub('Controller/api');

        $this->replaceNameSpace($stub, $this->controllerBaseNameSpace())
            ->replaceNameSpacedModel($stub)
            ->replaceRootNameSpace($stub)
            ->replaceClassName($stub, $this->getControllerName())
            ->replaceModel($stub)
            ->replaceResponsePath($stub)
            ->replaceModelVariable($stub);

        return $stub;
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
