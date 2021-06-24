<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain\Support;

use Exception;
use InvalidArgumentException;
use ReflectionClass;

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

    final public static function __callStatic(string $name, $args)
    {
        return new static(self::values()[$name]);
    }

    public function getInvalidException(string $value): Exception
    {
        return new InvalidArgumentException(
            sprintf("Invalid value (%s) for enum (%s)",$value, static::class)
        );
    }
}