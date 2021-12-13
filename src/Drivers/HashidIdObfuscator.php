<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Drivers;

use Hashids\Hashids;
use Lurza\IdObfuscator\Configs\HashidsConfig;
use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;

/**
 * @extends BaseIdObfucator<Hashids>
 */
class HashidIdObfuscator extends BaseIdObfucator
{
    public function __construct(
        private HashidsConfig $config
    ) {}

    public function encode(int $id): string
    {
        return $this->encodeWith($id, $this->getDefaultObfuscator());
    }

    /**
     * @throws InvalidIdException
     */
    private function encodeWith(int $id, Hashids $hashids): string
    {
        if ($id < 0) {
            throw new InvalidIdException("Ids can only be positive integers!");
        }

        return $hashids->encode($id);
    }

    public function decode(string $obfuscatedId): int
    {
        return $this->decodeWith($obfuscatedId, $this->getDefaultObfuscator());
    }

    /**
     * @throws InvalidObfuscatedIdException
     */
    private function decodeWith(string $obfuscatedId, Hashids $hashids): int
    {
        $ids = $hashids->decode($obfuscatedId);

        if (count($ids) < 1) {
            throw new InvalidObfuscatedIdException();
        }

        return $ids[0];
    }

    public function encodeClassSpecific(int $id, string $class): string
    {
        return $this->encodeWith($id, $this->getClassSpecificObfuscator($class));
    }

    public function decodeClassSpecific(string $obfuscatedId, string $class): int
    {
        return $this->decodeWith($obfuscatedId, $this->getClassSpecificObfuscator($class));
    }

    protected function createDefaultObfuscator(): Hashids
    {
        return new Hashids(
            $this->config->salt,
            $this->config->minimumHashLength,
            $this->config->alphabet
        );
    }

    protected function createClassSpecificObfuscator(string $class): Hashids
    {
        return new Hashids(
            $this->getClassSpecificSalt($class),
            $this->config->minimumHashLength,
            $this->config->alphabet
        );
    }

    private function getClassSpecificSalt(string $class): string
    {
        return hash('sha256', $this->config->salt . $class);
    }
}