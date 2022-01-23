<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

interface Rule
{
    public function validate($input, array $context = []): Violations;
}
