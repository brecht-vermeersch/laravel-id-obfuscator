<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator;

use Illuminate\Support\Manager;
use Lurza\IdObfuscator\Drivers\NullIdObfuscator;
use Lurza\IdObfuscator\Drivers\HashidIdObfuscator;
use Lurza\IdObfuscator\Drivers\Configs\HashidsConfig;
use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;

/**
 * @method IdObfuscatorContract driver(?string $driver = null)
 */
class IdObfuscatorManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return "hashids";
    }

    public function createHashidsDriver(): IdObfuscatorContract
    {
        return new HashidIdObfuscator(app(HashidsConfig::class));
    }

    public function createNullDriver(): IdObfuscatorContract
    {
        return new NullIdObfuscator();
    }
}