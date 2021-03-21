<?php

namespace Akira\ResourceBoilerplate;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Akira\ResourceBoilerplate\Skeleton\SkeletonClass
 */
class ResourceBoilerplateFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'resource-boilerplate';
    }
}
