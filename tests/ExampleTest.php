<?php

namespace Akira\ResourceBoilerplate\Tests;

use Orchestra\Testbench\TestCase;
use Akira\ResourceBoilerplate\ResourceBoilerplateServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [ResourceBoilerplateServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
