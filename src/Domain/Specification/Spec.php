<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification;

class Spec
{
    public static function and(Specification $specification, Specification ...$specifications): Specification
    {
        return new AllOf($specification, ...$specifications);
    }

    public static function or(Specification $specification, Specification ...$specifications): Specification
    {
        return new AnyOf($specification, ...$specifications);
    }

    public static function not(Specification $specification): Specification
    {
        return new Not($specification);
    }
}
