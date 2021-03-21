<?php

namespace Akira\ResourceBoilerplate\Traits;

use Illuminate\Support\Str;

use Illuminate\Container\Container;

trait CommonTrait
{


    protected function getAppNameSpace()
    {
        return Container::getInstance()->getNamespace();
    }


    protected function replaceNameSpace(&$stub, $namespace)
    {

        $namespace = $this->getAppNameSpace() . $namespace;


        $stub = str_replace('{{ namespace }}', $namespace, $stub);

        return $this;
    }

    protected function replaceRootNameSpace(&$stub)
    {
        $stub = str_replace('{{ rootNamespace }}', $this->getAppNameSpace(), $stub);
        return $this;
    }

    protected function replaceClassName(&$stub, $className)
    {
        $className = ucwords(Str::camel($className));

        $stub = str_replace('{{ class }}', $className, $stub);

        return $this;
    }

    protected function replaceModelNameSpace(&$stub, $model)
    {
        $model = ucwords(Str::camel($model));

        $modelNameSpaced = $this->getAppNameSpace() . 'Models\\' . $model;

        $stub = str_replace('{{ namespacedModel }}', $modelNameSpaced, $stub);

        return $this;
    }

    protected function replaceModel(&$stub, $model)
    {
        $model = ucwords(Str::camel($model));
        $stub = str_replace('{{ model }}', $model, $stub);
        return $this;
    }

    protected function replaceModelVariable(&$stub, $model)
    {
        $model = Str::lower($model);
        $stub = str_replace('{{ modelVariable }}', $model, $stub);
        return $this;
    }
}
