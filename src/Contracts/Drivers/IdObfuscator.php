<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Contracts\Drivers;

use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;

interface IdObfuscator
{

    /**
     * @param int $id
     * @param class-string|null $class
     * @return string
     * @throws InvalidIdException
     */
    public function encode(int $id, string $class = null): string;

    /**
     * @param string $obfuscatedId
     * @param class-string|null $class
     * @return int
     * @throws InvalidObfuscatedIdException
     */
    public function decode(string $obfuscatedId, string $class = null): int;
}