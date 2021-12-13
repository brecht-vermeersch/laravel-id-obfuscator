<?php

declare(strict_types=1);

namespace Lurza\IdObfuscator\Facades;

use Illuminate\Support\Facades\Facade;
use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;
use Lurza\IdObfuscator\IdObfuscatorManager;

/**
 * @see IdObfuscatorManager
 *
 * @method static IdObfuscatorContract driver(?string $driver = null)
 * @method static string encode(int $id, ?string $salt = null)
 * @method static int decode(string $obfuscatedId, ?string $salt = null)
 */
class IdObfuscator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IdObfuscatorManager::class;
    }
}
