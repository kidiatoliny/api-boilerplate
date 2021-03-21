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


    protected function stubVariable($variable)
    {
        return '{{ ' . $variable . ' }}';
    }


    protected function replaceNameSpace(&$stub, $namespace)
    {

        $namespace = $this->getAppNameSpace() . $namespace;
        $stub = str_replace($this->stubVariable('namespace'), $namespace, $stub);

        return $this;
    }

    protected function replaceRootNameSpace(&$stub)
    {
        $stub = str_replace($this->stubVariable('rootNamespace'), $this->getAppNameSpace(), $stub);
        return $this;
    }

    protected function replaceClassName(&$stub, $className)
    {
        $className = ucwords(Str::camel($className));

        $stub = str_replace($this->stubVariable('class'), $className, $stub);

        return $this;
    }


    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
    }

    protected function isDirectoryExist($path)
    {
        if (!$this->files->exists($path)) {
            return false;
        }
        return;
    }

    protected function getStub($stub)
    {
        return $this->files->get(__DIR__ . '/../Stubs/' . $stub . '.stub');
    }

    protected function getFolderStubs($folder)
    {
        return array_diff(scandir(__DIR__ . '/../Stubs/' . $folder), array('.', '..'));
    }


    protected function insertStubsIntoFiles()
    {
        $stubs = $this->getFolderStubs('Responses');

        foreach ($stubs as $stub) {
            $stb[] = explode('.', $stub);
        }

        return
            $stb;
    }
}
