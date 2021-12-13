<?php

declare(strict_types=1);

namespace Lurza\IdObfuscator\Contracts\Drivers;

use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;

interface IdObfuscator
{
    /**
     * @param int               $id
     * @param class-string|null $salt
     *
     * @throws InvalidIdException
     *
     * @return string
     */
    public function encode(int $id, string $salt = null): string;

    /**
     * @param string            $obfuscatedId
     * @param class-string|null $salt
     *
     * @throws InvalidObfuscatedIdException
     *
     * @return int
     */
    public function decode(string $obfuscatedId, string $salt = null): int;
}
