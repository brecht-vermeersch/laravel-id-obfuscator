<?php

namespace Lurza\IdObfuscator\Tests;

use Lurza\IdObfuscator\IdObfuscatorServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            IdObfuscatorServiceProvider::class,
        ];
    }
}