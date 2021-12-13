<?php

declare(strict_types=1);

namespace Lurza\IdObfuscator\Drivers\Configs;

use function config;
use Lurza\IdObfuscator\Exceptions\InvalidConfigurationException;

class HashidsConfig
{
    const DEFAULT_ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    const DEFAULT_MINIMUM_HASH_LENGTH = 0;

    public string $salt;
    public string $alphabet;
    public int $minimumHashLength;

    /**
     * @throws InvalidConfigurationException
     */
    public function __construct()
    {
        $config = $this->getConfig();

        $this->setSalt($config);
        $this->setAlphabet($config);
        $this->setMinimumHashLength($config);
    }

    /**
     * @throws InvalidConfigurationException
     *
     * @return array<string, mixed>
     */
    private function getConfig(): array
    {
        $config = config('idObfuscator.drivers.hashids');

        if (!is_array($config)) {
            throw new InvalidConfigurationException();
        }

        return $config;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws InvalidConfigurationException
     */
    private function setSalt(array $config): void
    {
        $salt = $config['salt'] ?? null;

        if (!is_string($salt)) {
            throw new InvalidConfigurationException('Config option salt is required and must be a string!');
        }

        $this->salt = $salt;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws InvalidConfigurationException
     */
    private function setAlphabet(array $config): void
    {
        $alphabet = $config['alphabet'] ?? self::DEFAULT_ALPHABET;

        if (!is_string($alphabet)) {
            throw new InvalidConfigurationException('Config option alphabet must be a string or null!');
        }

        $this->alphabet = $alphabet;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws InvalidConfigurationException
     */
    private function setMinimumHashLength(array $config): void
    {
        $minimumHashLength = $config['minimumHashLength'] ?? self::DEFAULT_MINIMUM_HASH_LENGTH;

        if (!is_int($minimumHashLength)) {
            throw new InvalidConfigurationException('Config option minimumHashLength must be an int or null!');
        }

        $this->minimumHashLength = $minimumHashLength;
    }
}
