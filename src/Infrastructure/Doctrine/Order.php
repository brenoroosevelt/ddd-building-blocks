<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

final class Order
{
    const ASC = 'asc';
    const DESC = 'desc';

    public static function by(string $alias, string $direction = self::ASC) : array
    {
        return [$alias => self::parseDirection($direction)];
    }

    public static function parseDirection($direction): string
    {
        return
            match (mb_strtolower((string) $direction)) {
                'desc' => Order::DESC,
                default => Order::ASC
            };
    }
}
