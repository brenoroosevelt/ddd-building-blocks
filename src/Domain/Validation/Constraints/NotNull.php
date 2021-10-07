<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotNull implements Constraint
{
    public function validate($input, array $context = []): ValidationResult
    {
        return
            null === $input ?
                ValidationResult::problem('O valor não pode ser nulo') :
                ValidationResult::ok();
    }
}
