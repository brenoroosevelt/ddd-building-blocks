<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

class Utility
{
    public static function range($value, $min, $max)
    {
        return min(max($min, $value), $max);
    }

    public static function coalesce(...$v)
    {
        $filtered = array_filter($v);
        return array_shift($filtered);
    }
}
