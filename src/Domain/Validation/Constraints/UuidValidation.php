<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UuidValidation implements Constraint
{
    public function validate($input, array $context = []): ValidationResult
    {
        return \Ramsey\Uuid\Uuid::isValid((string) $input) ?
            ValidationResult::ok() :
            ValidationResult::problem("UUID inválido");
    }
}
