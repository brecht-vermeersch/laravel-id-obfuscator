<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Drivers;

use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as ObfuscatorContract;

/**
 * @template T
 */
abstract class BaseIdObfucator implements ObfuscatorContract
{
    /** @var ?T $cachedDefault */
    private mixed $cachedDefault = null;
    /** @var array<class-string, T> */
    private array $cachedSalted = [];

    /**
     * @return T
     */
    protected function getDefaultObfuscator(): mixed
    {
        return $this->cachedDefault !== null
            ? $this->cachedDefault
            : $this->cachedDefault = $this->createDefaultObfuscator();
    }

    /**
     * @param class-string $salt
     * @return T
     */
    protected function getSaltedObfuscator(string $salt): mixed
    {
        return array_key_exists($salt, $this->cachedSalted)
            ? $this->cachedSalted[$salt]
            : $this->cachedSalted[$salt] = $this->createSaltedObfuscator($salt);
    }

    /**
     * @param class-string|null $salt
     * @return T
     */
    protected function getSaltedOrDefaultObfuscator(?string $salt): mixed
    {
        return $salt === null
            ? $this->getDefaultObfuscator()
            : $this->getSaltedObfuscator($salt);
    }

    /**
     * @return T
     */
    abstract protected function createDefaultObfuscator(): mixed;

    /**
     * @param class-string $salt
     * @return T
     */
    abstract protected function createSaltedObfuscator(string $salt): mixed;
}