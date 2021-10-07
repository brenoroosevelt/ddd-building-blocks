<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

interface Constraint
{
    public function validate($input, array $context = []): ValidationResult;
}
