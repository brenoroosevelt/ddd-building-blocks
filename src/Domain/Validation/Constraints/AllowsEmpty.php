<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

class AllowsEmpty implements Constraint
{
    public function validate($input, array $context = []): ValidationResult
    {
        return ValidationResult::ok();
    }
}
