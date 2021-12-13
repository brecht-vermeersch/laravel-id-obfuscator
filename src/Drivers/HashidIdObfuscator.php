<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Drivers;

use Hashids\Hashids;
use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Lurza\IdObfuscator\Exceptions\InvalidConfigurationException;

/**
 * @extends BaseIdObfucator<Hashids>
 */
class HashidIdObfuscator extends BaseIdObfucator
{
    private string $salt;
    private string $alphabet;
    private int $minimumHashLength;

    /**
     * @throws InvalidConfigurationException
     */
    public function __construct(ConfigRepository $config)
    {
        $this->setSalt($config);
        $this->setAlphabet($config);
        $this->setMinimumHashLength($config);
    }

    /**
     * @throws InvalidConfigurationException
     */
    private function setSalt(ConfigRepository $config): void
    {
        $salt = $config->get("salt");

        if (!is_string($salt)) {
            throw new InvalidConfigurationException("config option salt is required and must be a string!");
        }

        $this->salt = $salt;
    }

    /**
     * @throws InvalidConfigurationException
     */
    private function setAlphabet(ConfigRepository $config): void
    {
        $alphabet = $config->get("alphabet");

        if ($alphabet !== null && !is_string($alphabet)) {
            throw new InvalidConfigurationException("Config option alphabet must be a string or null!");
        }

        $this->alphabet = $alphabet ?? "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    }

    /**
     * @throws InvalidConfigurationException
     */
    private function setMinimumHashLength(ConfigRepository $config): void
    {
        $minimumHashLength = $config->get("minimumHashLength");

        if ($minimumHashLength !== null && !is_int($minimumHashLength)) {
            throw new InvalidConfigurationException("Config option minimumHashLength must be an int or null!");
        }

        $this->minimumHashLength = $minimumHashLength ?? 0;
    }

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
        return new Hashids($this->salt, $this->minimumHashLength, $this->alphabet);
    }

    protected function createClassSpecificObfuscator(string $class): Hashids
    {
        $salt = hash('sha256', $this->salt . $class);
        return new Hashids($salt, $this->minimumHashLength, $this->alphabet);
    }
}