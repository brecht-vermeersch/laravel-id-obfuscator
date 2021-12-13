<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Contracts\Drivers;

use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;

interface IdObfuscator
{

    /**
     * @param int $id
     * @param class-string|null $salt
     * @return string
     * @throws InvalidIdException
     */
    public function encode(int $id, string $salt = null): string;

    /**
     * @param string $obfuscatedId
     * @param class-string|null $salt
     * @return int
     * @throws InvalidObfuscatedIdException
     */
    public function decode(string $obfuscatedId, string $salt = null): int;
}