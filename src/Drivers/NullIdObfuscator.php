<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Drivers;

use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;

class NullIdObfuscator implements IdObfuscatorContract
{

    public function encode(int $id): string
    {
        return (string) $id;
    }

    public function decode(string $obfuscatedId): int
    {
        return (int) $obfuscatedId;
    }

    public function encodeClassSpecific(int $id, string $class): string
    {
        return $this->encode($id);
    }

    public function decodeClassSpecific(string $obfuscatedId, string $class): int
    {
        return $this->decode($obfuscatedId);
    }
}