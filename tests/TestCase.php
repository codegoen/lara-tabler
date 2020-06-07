<?php

namespace Rizkhal\Tabler\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

use Illuminate\Contracts\Console\Kernel;
use Rizkhal\Tabler\TablerServiceProvider;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function getPackageProviders($app)
    {
        return [
            TablerServiceProvider::class
        ];
    }
}
