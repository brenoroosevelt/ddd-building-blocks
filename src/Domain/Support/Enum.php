<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain\Support;

use InvalidArgumentException;
use ReflectionClass;
use Throwable;

abstract class Enum extends StringType
{
    private static array $values;

    final public function __construct(string $value)
    {
        if (!in_array($value, static::values(), true)) {
            throw $this->getInvalidException($value);
        }

        parent::__construct($value);
    }

    final public static function values(): array
    {
        if (empty(self::$values[static::class])) {
            self::$values[static::class] = (new ReflectionClass(static::class))->getConstants();
        }

        return self::$values[static::class];
    }

    final public static function flipValues(): array
    {
        return array_flip(self::values());
    }

    final public static function onlyValues(): array
    {
        return array_values(self::values());
    }

    final public static function onlyKeys(): array
    {
        return array_keys(self::values());
    }

    final public static function __callStatic(string $name, $args)
    {
        return new static(self::values()[$name]);
    }

    protected function getInvalidException(string $value): Throwable
    {
        return new InvalidArgumentException(
            sprintf("Invalid value (%s) for enum (%s)",$value, static::class)
        );
    }
}
