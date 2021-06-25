<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification\Specification;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\DateTime;

class Recent implements Specification
{
    private int $daysAgo;

    public function __construct(int $daysAgo)
    {
        assert($daysAgo >= 0);
        $this->daysAgo = $daysAgo;
    }

    /**
     * @param DateTime $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate): bool
    {
        $daysAgo = DateTime::now()->modify("-$this->daysAgo days");
        var_dump($daysAgo);
        return $candidate >= $daysAgo;
    }
}
