<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator;

use Illuminate\Support\Manager;
use Lurza\IdObfuscator\Configs\HashidsConfig;
use Lurza\IdObfuscator\Drivers\HashidIdObfuscator;
use Lurza\IdObfuscator\Drivers\NullIdObfuscator;
use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;

/**
 * @method IdObfuscatorContract driver(?string $driver = null)
 */
class IdObfuscatorManager extends Manager implements IdObfuscatorContract
{
    public function getDefaultDriver(): string
    {
        return "hashids";
    }

    /**
     * @return IdObfuscatorContract
     */
    public function createHashidsDriver(): IdObfuscatorContract
    {
        return new HashidIdObfuscator(new HashidsConfig);
    }

    public function createNullDriver(): IdObfuscatorContract
    {
        return new NullIdObfuscator();
    }

    public function encode(int $id, string $class = null): string
    {
        return $this->driver()->encode($id, $class);
    }

    public function decode(string $obfuscatedId, string $class = null): int
    {
        return $this->driver()->decode($obfuscatedId, $class);
    }
}