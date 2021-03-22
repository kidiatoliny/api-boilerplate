<?php

namespace Akira\ResourceBoilerplate\Traits;

use Akira\ResourceBoilerplate\Traits\ModelTrait;
use Akira\ResourceBoilerplate\Traits\CommonTrait;
use Akira\ResourceBoilerplate\Traits\ControllerTrait;


trait RouteTrait
{
    use CommonTrait;
    use ModelTrait;
    use ControllerTrait;

    protected function routeBasePath()
    {
        return base_path('routes');
    }

    protected function apiPathName()
    {
        return $this->routeBasePath() . '/api.php';
    }



    protected function addUseStatementToRoute()
    {
        $file = $this->apiPathName();
        $search = '<?php';
        $useStatement = $this->controllerUseStatement();
        $replace = $search . "\n" . $useStatement;
        file_put_contents($file, str_replace($search, $replace, file_get_contents($file)));
    }

    protected function isaddUseStatement()
    {
        $search = $this->controllerUseStatement();
        if (!$search) {
            return false;
        }
        return true;
    }

    protected function compileRouteStub()
    {
        $stub = $this->getStub('Routes/api/group');
        $this->replaceTableName($stub)
            ->replaceController($stub)
            ->appendStubToApiRoutes($stub);
        return $stub;
    }


    protected function appendStubToApiRoutes($stub)
    {
        $this->addUseStatementToRoute();

        $this->files->append(
            $this->apiPathName(),
            $stub
        );
    }

    protected function apiRoutesAppended()
    {
        return $this->info('Routes ' . $this->tableName() . ' appended to ' . $this->apiPathName());
    }

    protected function replaceTableName(&$stub)
    {
        $variable = $this->stubVariable('tableName');
        $value = $this->tableName();
        $stub = str_replace($variable, $value, $stub);
        return $this;
    }
    protected function replaceController(&$stub)
    {
        $variable = $this->stubVariable('controller');
        $value = $this->getControllerName();
        $stub = str_replace($variable, $value, $stub);
        return $this;
    }
}
