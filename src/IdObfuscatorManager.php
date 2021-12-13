<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator;

use Illuminate\Support\Manager;
use Lurza\IdObfuscator\Configs\HashidsConfig;
use Lurza\IdObfuscator\Drivers\HashidIdObfuscator;
use Lurza\IdObfuscator\Drivers\NullIdObfuscator;
use Lurza\IdObfuscator\Exceptions\InvalidConfigurationException;
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
     * @param array<string, mixed> $connectionConfig
     * @return IdObfuscatorContract
     * @throws InvalidConfigurationException
     */
    public function createHashidsDriver(array $connectionConfig): IdObfuscatorContract
    {
        return new HashidIdObfuscator(new HashidsConfig($connectionConfig));
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