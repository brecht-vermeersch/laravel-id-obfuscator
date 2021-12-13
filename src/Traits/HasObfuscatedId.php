<?php declare(strict_types=1);

namespace Lurza\IdObfuscator\Traits;

use Illuminate\Database\Eloquent\Model;
use Lurza\IdObfuscator\Exceptions\InvalidDriverException;
use Lurza\IdObfuscator\Exceptions\InvalidKeyException;
use Lurza\IdObfuscator\Facades\IdObfuscator;
use Lurza\IdObfuscator\Exceptions\InvalidIdException;
use Lurza\IdObfuscator\Exceptions\InvalidObfuscatedIdException;
use Lurza\IdObfuscator\Contracts\Drivers\IdObfuscator as IdObfuscatorContract;

/**
 * @mixin Model
 */
trait HasObfuscatedId
{
    protected ?string $idObfuscator = null;
    protected bool $classSpecificIdObfuscator = false;

    /**
     * @throws InvalidDriverException|InvalidKeyException|InvalidIdException
     */
    public function getRouteKey(): string
    {
        $key = $this->getKey();

        if (!$this->isDigits($key)) {
            throw new InvalidKeyException("Key must only contain digits!");
        }

        /** @var string|int $key */
        return $this->encodeId((int)$key);
    }

    private function isDigits(mixed $var): bool
    {
        return is_int($var) || (is_string($var) && ctype_digit($var));
    }

    /**
     * @throws InvalidIdException|InvalidDriverException
     */
    private function encodeId(int $id): string
    {
        if ($this->classSpecificIdObfuscator) {
            return $this->getIdObfuscator()->encodeClassSpecific($id, static::class);
        }

        return $this->getIdObfuscator()->encode($id);
    }

    /**
     * @throws InvalidDriverException
     */
    private function getIdObfuscator(): IdObfuscatorContract
    {
        $driver = IdObfuscator::driver($this->idObfuscator);

        if (!$driver instanceof IdObfuscatorContract) {
            throw new InvalidDriverException("Driver " . $this->idObfuscator . "not found!");
        }

        return $driver;
    }

    /**
     * @throws InvalidDriverException
     */
    public function resolveRouteBinding(string $value, ?string $field = null): ?Model
    {
        try {
            $decoded = $this->decodeId($value);
        } catch (InvalidObfuscatedIdException) {
            return null;
        }

        return $this
            ->newQuery()
            ->where($field ?? $this->getRouteKeyName(), $decoded)
            ->first();
    }

    /**
     * @throws InvalidDriverException|InvalidObfuscatedIdException
     */
    private function decodeId(string $obfuscatedId): int
    {
        if ($this->classSpecificIdObfuscator) {
            return $this->getIdObfuscator()->decodeClassSpecific($obfuscatedId, static::class);
        }

        return $this->getIdObfuscator()->decode($obfuscatedId);
    }
}