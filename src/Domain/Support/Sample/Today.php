<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\DateTime;

class Today implements Specification
{
    /**
     * @param DateTime $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate): bool
    {
        return $candidate->format('d/m/Y') == DateTime::now()->format('d/m/Y');
    }
}
