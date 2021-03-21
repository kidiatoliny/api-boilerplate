<?php

namespace Akira\ResourceBoilerplate\Traits;

use Illuminate\Support\Str;
use Akira\ResourceBoilerplate\Traits\ModelTrait;
use Akira\ResourceBoilerplate\Traits\CommonTrait;


trait ResponsesTrait
{
    use CommonTrait;
    use ModelTrait;

    protected function basePath()
    {
        return base_path('storage\\responses\\');
    }

    protected function responsePathName()
    {
        return Str::pluralStudly(Str::kebab($this->getModelName()));
    }

    protected function responsePath()
    {
        return  $this->basePath() . $this->responsePathName();
    }
    protected function createPathsIfIsNoExists()
    {

        if (!$this->isDirectoryExist($this->basePath())) {
            $this->makeDirectory($this->basePath());
        }

        if (!$this->makeDirectory($this->responsePath())) {
            $this->makeDirectory($this->responsePath());
        }

        return $this;
    }

    protected function compileResponseStub()
    {
        return $this->insertStubsIntoFiles('Responses');
    }


    protected function createResponseFiles()
    {
        foreach ($this->compileResponseStub() as $stub) {
            $filePath =  $this->responsePath() . '/' . $stub[0] . '.json';

            if (!$this->files->exists($filePath)) {

                $this->files->put(
                    $filePath,
                    $this->getStub('Responses/' . $stub[0])
                );
            }
        }
    }



    protected function makeResposes()
    {
        $this->createResponseFiles();
        $this->info('Responses ' . $this->getModelName() . ' created');
    }
}
