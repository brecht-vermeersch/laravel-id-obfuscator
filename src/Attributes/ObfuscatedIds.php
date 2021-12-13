<?php

declare(strict_types=1);

namespace Lurza\IdObfuscator\Attributes;

use Attribute;

#[Attribute]
class ObfuscatedIds
{
    /**
     * @param array<string|int, string|class-string> $keys
     */
    public function __construct(
        public array $keys
    ) {
    }
}
