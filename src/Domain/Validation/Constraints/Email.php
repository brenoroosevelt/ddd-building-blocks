<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Email implements Constraint
{
    public function validate($input, array $context = []): ValidationResult
    {
        return
            filter_var($input, FILTER_VALIDATE_EMAIL) === false ?
                ValidationResult::problem("E-mail inválido") :
                ValidationResult::ok();
    }
}
