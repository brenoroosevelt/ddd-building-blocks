<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain;

abstract class ValueObject implements Comparable
{
    use Comparison;
    use SpecificationTrait;

    public function equals($v): bool
    {
        return $v == $this;
    }
}
