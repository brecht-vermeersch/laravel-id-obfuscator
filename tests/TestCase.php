<?php

namespace Lurza\IdObfuscator\Tests;

use Illuminate\Database\Schema\Blueprint;
use Lurza\IdObfuscator\IdObfuscatorServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app): array
    {
        return [
            IdObfuscatorServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('idObfuscator', [
            'default' => 'hashids',
            'drivers' => [
                'hashids' => [
                    'salt' => 'salt',
                ],
                'optimus' => [
                    'prime'   => env('OPTIMUS_PRIME'),
                    'inverse' => env('OPTIMUS_INVERSE'),
                    'random'  => env('OPTIMUS_RANDOM'),
                ],
                'null' => [],
            ],
        ]);

        $app['db']->connection()->getSchemaBuilder()->create('dummies', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }
}
