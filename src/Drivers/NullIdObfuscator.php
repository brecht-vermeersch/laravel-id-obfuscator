<?php

declare(strict_types=1);

namespace Lurza\IdObfuscator\Drivers;

use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;

class NullIdObfuscator implements IdObfuscatorContract
{
    public function encode(int $id, string $salt = null): string
    {
        return (string) $id;
    }

    public function decode(string $obfuscatedId, string $salt = null): int
    {
        return (int) $obfuscatedId;
    }
}
