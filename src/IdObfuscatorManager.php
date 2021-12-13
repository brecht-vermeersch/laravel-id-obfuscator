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

    public function encode(int $id): string
    {
        return $this->driver()->encode($id);
    }

    public function decode(string $obfuscatedId): int
    {
        return $this->driver()->decode($obfuscatedId);
    }

    public function encodeClassSpecific(int $id, string $class): string
    {
        return $this->driver()->encodeClassSpecific($id, $class);
    }

    public function decodeClassSpecific(string $obfuscatedId, string $class): int
    {
        return $this->driver()->decodeClassSpecific($obfuscatedId, $class);
    }
}