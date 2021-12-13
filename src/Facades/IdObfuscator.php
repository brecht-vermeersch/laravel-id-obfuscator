<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Facades;

use Illuminate\Support\Facades\Facade;
use Lurza\IdObfuscator\IdObfuscatorManager;
use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;

/**
 * @see IdObfuscatorManager
 * @method static IdObfuscatorContract driver(?string $driver = null)
 * @method static string encode(int $id)
 * @method static int decode(string $obfuscatedId)
 * @method static string encodeClassSpecific(int $id, string $class)
 * @method static int decodeClassSpecific(string $obfuscatedId, string $class)
 */
class IdObfuscator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'idObfuscator';
    }
}