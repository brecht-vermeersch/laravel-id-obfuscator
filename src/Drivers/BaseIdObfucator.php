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
    private array $cachedClassSpecifics = [];

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
     * @param class-string $class
     * @return T
     */
    protected function getClassObfuscator(string $class): mixed
    {
        return array_key_exists($class, $this->cachedClassSpecifics)
            ? $this->cachedClassSpecifics[$class]
            : $this->cachedClassSpecifics[$class] = $this->createClassSpecificObfuscator($class);
    }

    /**
     * @param class-string|null $class
     * @return T
     */
    protected function getClassOrDefaultObfuscator(?string $class): mixed
    {
        return $class === null
            ? $this->getDefaultObfuscator()
            : $this->getClassObfuscator($class);
    }

    /**
     * @return T
     */
    abstract protected function createDefaultObfuscator(): mixed;

    /**
     * @param class-string $class
     * @return T
     */
    abstract protected function createClassSpecificObfuscator(string $class): mixed;
}