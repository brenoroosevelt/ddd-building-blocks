<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BooleanValidation extends AbstractConstraint
{
    protected static string $defaultMessage = 'Valor deve ser um boleano';

    public function validate($input, array $context = []): ValidationResult
    {
        return is_bool($input)? $this->ok() : $this->error();
    }
}
