<?php

namespace Akira\ResourceBoilerplate\Traits;

use Illuminate\Support\Str;


trait ModelTrait
{

    /**
     * Model Base namespace
     *
     * @return string
     */
    protected function modelBaseNameSpace()
    {
        return 'Models';
    }

    protected function modelNameSpace()
    {
        return $this->modelBaseNameSpace() . '\\' . $this->getModelName();
    }

    protected function modelBasePath()
    {
        return app_path('Models/');
    }

    protected function modelPath()
    {
        return $this->modelBasePath() .  $this->getModelName() . '.php';
    }
    /**
     * Replace Model namepsace with the current model namespace
     *
     * @param [stub] $stub
     * @return namespace
     */
    protected function replaceModelNameSpace(&$stub)
    {

        $stub = str_replace(
            '{{ namespacedModel }}',
            $this->modelNameSpace(),
            $stub
        );

        return $this;
    }


    /**
     * Verify is Model Path exist
     *
     * @return boolean
     */
    protected function isModelPathExist()
    {

        if ($this->files->exists($this->modelPath())) {
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



    protected function modelCreated()
    {
        return $this->info('Model ' . $this->getModelName() . ' created');
    }



    protected function compileModelStub()
    {
        $stub = $this->getStub('Model/model');

        $this->replaceClassName($stub, $this->getModelName())
            ->replaceNameSpace($stub, $this->modelBaseNameSpace());

        return $stub;
    }


    protected function makeModel()
    {
        $this->files->put(
            $this->modelPath(),
            $this->compileModelStub()
        );

        $this->modelCreated();
    }
}
