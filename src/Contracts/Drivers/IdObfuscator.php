<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Contracts\Drivers;

use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;

interface IdObfuscator
{

    /**
     * @param int $id
     * @return string
     * @throws InvalidIdException
     */
    public function encode(int $id): string;

    /**
     * @param string $obfuscatedId
     * @return int
     * @throws InvalidObfuscatedIdException
     */
    public function decode(string $obfuscatedId): int;

    /**
     * @param int $id
     * @param class-string $class
     * @return string
     * @throws InvalidIdException
     */
    public function encodeClassSpecific(int $id, string $class): string;

    /**
     * @param string $obfuscatedId
     * @param class-string $class
     * @return int
     * @throws InvalidObfuscatedIdException
     */
    public function decodeClassSpecific(string $obfuscatedId, string $class): int;
}