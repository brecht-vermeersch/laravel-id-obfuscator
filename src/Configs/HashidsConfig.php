<?php declare(strict_types=1);

namespace Lurza\IdObfuscator\Configs;

use Lurza\IdObfuscator\Exceptions\InvalidConfigurationException;

class HashidsConfig
{
    const DEFAULT_ALPHABET = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    const DEFAULT_MINIMUM_HASH_LENGTH = 0;

    public string $salt;
    public string $alphabet;
    public int $minimumHashLength;

    /**
     * @param array<string, mixed> $connectionConfig
     * @throws InvalidConfigurationException
     */
    public function __construct(array $connectionConfig)
    {
        $this->setSalt($connectionConfig);
        $this->setAlphabet($connectionConfig);
        $this->setMinimumHashLength($connectionConfig);
    }

    /**
     * @param array<string, mixed> $connectionConfig
     * @throws InvalidConfigurationException
     */
    private function setSalt(array $connectionConfig): void
    {
        $salt = $connectionConfig["salt"] ?? null;

        if (!is_string($salt)) {
            throw new InvalidConfigurationException("Config option salt is required and must be a string!");
        }

        $this->salt = $salt;
    }

    /**
     * @param array<string, mixed> $connectionConfig
     * @throws InvalidConfigurationException
     */
    private function setAlphabet(array $connectionConfig): void
    {
        $alphabet = $connectionConfig["alphabet"] ?? self::DEFAULT_ALPHABET;

        if (!is_string($alphabet)) {
            throw new InvalidConfigurationException("Config option alphabet must be a string or null!");
        }

        $this->alphabet = $alphabet;
    }

    /**
     * @param array<string, mixed> $connectionConfig
     * @throws InvalidConfigurationException
     */
    private function setMinimumHashLength(array $connectionConfig): void
    {
        $minimumHashLength = $connectionConfig["minimumHashLength"] ?? self::DEFAULT_MINIMUM_HASH_LENGTH;

        if (!is_int($minimumHashLength)) {
            throw new InvalidConfigurationException("Config option minimumHashLength must be an int or null!");
        }

        $this->minimumHashLength = $minimumHashLength;
    }
}