<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use Exception;
use Throwable;

final class Assert
{
    public static function true(callable|bool $condition, string|Throwable $error): void
    {
        $test = is_bool($condition) ? $condition : call_user_func($condition);
        if (true !== $test) {
            Assert::throw($error);
        }
    }

    public static function false(callable|bool $condition, string|Throwable $error): void
    {
        $test = is_bool($condition) ? $condition : call_user_func($condition);
        if (false !== $test) {
            Assert::throw($error);
        }
    }

    public static function equals($v1, $v2, string|Throwable $error): void
    {
        Assert::true($v1 == $v2, $error);
    }

    public static function notEquals($v1, $v2, string|Throwable $error): void
    {
        Assert::true($v1 != $v2, $error);
    }

    public static function exacty($v1, $v2, string|Throwable $error): void
    {
        Assert::true($v1 === $v2, $error);
    }

    public static function notExacty($v1, $v2, string|Throwable $error): void
    {
        Assert::true($v1 !== $v2, $error);
    }

    public static function empty($value, string|Throwable $error): void
    {
        Assert::true(empty($value), $error);
    }

    public static function notEmpty($value, string|Throwable $error): void
    {
        Assert::true(!empty($value), $error);
    }

    public static function null($value, string|Throwable $error): void
    {
        Assert::true(null === $value, $error);
    }

    public static function notNull($value, string|Throwable $error): void
    {
        Assert::true(null !== $value, $error);
    }

    public static function greatherThan($n, $value, string|Throwable $error): void
    {
        Assert::true($value > $n, $error);
    }

    public static function greatherThanEqual($n, $value, string|Throwable $error): void
    {
        Assert::true($value >= $n, $error);
    }

    public static function lessThan($n, $value, string|Throwable $error): void
    {
        Assert::true($value < $n, $error);
    }

    public static function lessThanEqual($n, $value, string|Throwable $error): void
    {
        Assert::true($value <= $n, $error);
    }

    public static function between($i, $f, $value, string|Throwable $error): void
    {
        Assert::true($value >= $i && $value <= $f, $error);
    }

    public static function string($value, string|Throwable $error): void
    {
        Assert::true(is_string($value), $error);
    }

    public static function boolean($value, string|Throwable $error): void
    {
        Assert::true(is_bool($value), $error);
    }

    public static function int($value, string|Throwable $error): void
    {
        Assert::true(is_int($value), $error);
    }

    public static function float($value, string|Throwable $error): void
    {
        Assert::true(is_float($value), $error);
    }

    public static function numeric($value, string|Throwable $error): void
    {
        Assert::true(is_numeric($value), $error);
    }

    public static function instanceOf($objectOrClass, $value, string|Throwable $error): void
    {
        Assert::true(is_subclass_of($value, $objectOrClass, true), $error);
    }

    public static function allInstanceOf($objectOrClass, iterable $values, string|Throwable $error): void
    {
        foreach ($values as $value) {
            Assert::instanceOf($objectOrClass, $value, $error);
        }
    }

    public static function match($pattern, $value, string|Throwable $error): void
    {
        Assert::true(preg_match($pattern, $value) === 1, $error);
    }

    public static function inList(iterable $list, $value, string|Throwable $error): void
    {
        Assert::true(Arr::some($list, fn($el) => $el === $value), $error);
    }

    public static function dateTimeFormat(string $format, string $value, string|Throwable $error): void
    {
        $d = \DateTime::createFromFormat($format, $value);
        Assert::true($d && $d->format($format) === $value, $error);
    }

    private static function throw(string|Throwable $error): void
    {
        if ($error instanceof Throwable) {
            throw $error;
        }

        throw new Exception($error);
    }
}
