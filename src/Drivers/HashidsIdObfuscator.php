<?php declare(strict_types=1);

namespace Lurza\IdObfuscator\Drivers;

use Hashids\Hashids;
use Lurza\IdObfuscator\Drivers\Configs\HashidsConfig;
use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;

/**
 * @extends BaseIdObfucator<Hashids>
 */
class HashidsIdObfuscator extends BaseIdObfucator
{
    public function __construct(
        private HashidsConfig $config
    ) {}

    public function encode(int $id, string $salt = null): string
    {
        if ($id < 0) {
            throw new InvalidIdException("Ids can only be positive integers!");
        }

        return $this->getSaltedOrDefaultObfuscator($salt)->encode($id);
    }

    public function decode(string $obfuscatedId, string $salt = null): int
    {
        $ids = $this->getSaltedOrDefaultObfuscator($salt)->decode($obfuscatedId);

        if (count($ids) < 1 || $ids[0] === "") {
            throw new InvalidObfuscatedIdException();
        }

        return $ids[0];
    }

    protected function createDefaultObfuscator(): Hashids
    {
        return new Hashids(
            $this->config->salt,
            $this->config->minimumHashLength,
            $this->config->alphabet
        );
    }

    protected function createSaltedObfuscator(string $salt): Hashids
    {
        return new Hashids(
            $this->combineWithConfigSalt($salt),
            $this->config->minimumHashLength,
            $this->config->alphabet
        );
    }

    private function combineWithConfigSalt(string $salt): string
    {
        return hash('sha256', $this->config->salt . $salt);
    }

}