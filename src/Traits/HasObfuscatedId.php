<?php declare(strict_types=1);

namespace Lurza\IdObfuscator\Traits;

use Illuminate\Database\Eloquent\Model;
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
    protected bool $classBasedIdObfuscation = false;

    /**
     * @throws InvalidIdException
     */
    public function encodeObfuscatedId(int $id): string
    {
        return $this->getIdObfuscator()->encode($id);
    }

    /**
     * @throws InvalidObfuscatedIdException
     */
    public function decodeObfuscatedId(string $obfuscatedId): int
    {
        return $this->getIdObfuscator()->decode($obfuscatedId);
    }

    public function getIdObfuscator(): IdObfuscatorContract
    {
        /** @phpstan-ignore-next-line */
        return IdObfuscator::driver($this->idObfuscator);
    }

    /**
     * @throws InvalidIdException
     */
    public function getRouteKey(): string
    {
        $key = $this->getKey();

        if(!$this->isDigits($key)) {
            throw new InvalidIdException("Id should only contain digits!");
        }

        /** @var string|int $key */
        return $this->encodeObfuscatedId((int) $key);
    }

    private function isDigits(mixed $var): bool
    {
        return is_int($var) || (is_string($var) && ctype_digit($var));
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        try {
            $decodedValue = $this->decodeObfuscatedId($value);
        } catch (InvalidObfuscatedIdException) {
            return null;
        }

        return $this
            ->newQuery()
            ->where($field ?? $this->getRouteKeyName(), $decodedValue)
            ->first();
    }
}