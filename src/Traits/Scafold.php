<?php

namespace Akira\ResourceBoilerplate\Traits;


use Akira\ResourceBoilerplate\Traits\CommonTrait;

trait Scafold
{
    use CommonTrait;
    private $controllerNamespace = 'Http\Controllers';
    private $modelNameSpace = 'Models';

    protected function compileControllerStub()
    {
        $stub = $this->files->get(__DIR__ . '/../Stubs/Controller/api.stub');

        $model = $this->argument('model');
        $controller = $model . 'Controller';
        $this->replaceClassName($stub, $controller)
            ->replaceNameSpace($stub, $this->controllerNamespace)
            ->replaceRootNameSpace($stub)
            ->replaceModelNameSpace($stub, $model)
            ->replaceModel($stub, $model)
            ->replaceModelVariable($stub, $model);

        return $stub;
    }

    protected function compileModelStub()
    {
        $stub = $this->files->get(__DIR__ . '/../Stubs/Model/model.stub');

        $model = $this->argument('model');

        $this->replaceClassName($stub, $model)
            ->replaceNameSpace($stub, $this->modelNameSpace);

        return $stub;
    }
}
