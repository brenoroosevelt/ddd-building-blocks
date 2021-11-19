<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\Specification\Candidate;

abstract class ValueObject implements Comparable
{
    use ComparisonTrait;
    use Candidate;

    /**
     * @param static $v
     * @return bool
     */
    public function equals($v): bool
    {
        return $v instanceof $this && $v == $this;
    }
}
