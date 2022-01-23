<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

class Arr
{
    public static function first(iterable $values, callable $fn)
    {
        foreach ($values as $key => $value) {
            if (true === call_user_func_array($fn, [$value, $key])) {
                return $value;
            }
        }

        return null;
    }

    public static function some(iterable $values, callable $fn): bool
    {
        foreach ($values as $key => $value) {
            if (true === call_user_func_array($fn, [$value, $key])) {
                return true;
            }
        }

        return false;
    }

    public static function none(iterable $values, callable $fn): bool
    {
        return !Arr::some($values, $fn);
    }

    public static function sum(iterable $values, callable $fn): float
    {
        $sum = 0.0;
        foreach ($values as $key => $value) {
            $sum += call_user_func_array($fn, [$value, $key]);
        }

        return $sum;
    }

    public static function count(iterable $values, callable $fn): int
    {
        $count = 0;
        foreach ($values as $key => $value) {
            if (true === call_user_func_array($fn, [$value, $key])) {
                $count++;
            }
        }

        return $count;
    }
}
