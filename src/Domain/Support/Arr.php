<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

class Arr
{
    public static function first(iterable $values, callable $filter)
    {
        foreach ($values as $k => $v) {
            if (true === $filter($v, $k)) {
                return $v;
            }
        }

        return null;
    }

    public static function some(iterable $values, callable $filter): bool
    {
        foreach ($values as $k => $v) {
            if (true === $filter($v, $k)) {
                return true;
            }
        }

        return false;
    }

    public static function none(iterable $values, callable $filter): bool
    {
        return !Arr::some($values, $filter);
    }

    public static function sum(iterable $values, callable $fn): float
    {
        $sum = 0.0;
        foreach ($values as $key => $item) {
            $sum += $fn($item, $key);
        }

        return $sum;
    }

    public static function count(iterable $values, callable $fn): int
    {
        $count = 0;
        foreach ($values as $key => $item) {
            if (true === $fn($item, $key)) {
                $count++;
            }
        }

        return $count;
    }
}
