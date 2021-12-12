<?php

namespace Lurza\Skeleton\Tests;

use Lurza\Skeleton\SkeletonServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            SkeletonServiceProvider::class,
        ];
    }
}