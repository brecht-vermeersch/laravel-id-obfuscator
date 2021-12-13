<?php

declare(strict_types=1);

namespace Lurza\IdObfuscator;

use Illuminate\Support\Manager;
use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;
use Lurza\IdObfuscator\Drivers\Configs\HashidsConfig;
use Lurza\IdObfuscator\Drivers\HashidsIdObfuscator;
use Lurza\IdObfuscator\Drivers\NullIdObfuscator;

/**
 * @method IdObfuscatorContract driver(?string $driver = null)
 */
class IdObfuscatorManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return 'hashids';
    }

    public function createHashidsDriver(): IdObfuscatorContract
    {
        return new HashidsIdObfuscator(app(HashidsConfig::class));
    }

    public function createNullDriver(): IdObfuscatorContract
    {
        return new NullIdObfuscator();
    }
}
