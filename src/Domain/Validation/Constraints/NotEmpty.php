<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEmpty implements Constraint
{
    public function validate($input, array $context = []): ValidationResult
    {
        return
            empty($input) ?
                ValidationResult::problem('O valor não pode ser vazio') :
                ValidationResult::ok();
    }
}
