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

    private static function throw(string|Throwable $error): void
    {
        if ($error instanceof Throwable) {
            throw $error;
        }

        throw new Exception($error);
    }
}
