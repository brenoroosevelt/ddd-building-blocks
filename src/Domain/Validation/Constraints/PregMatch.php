<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PregMatch implements Constraint
{
    public function __construct(private string $pattern)
    {
    }

    public function validate($input, array $context = []): ValidationResult
    {
        if (preg_match($this->pattern, $input) === 1) {
            return ValidationResult::ok();
        }

        return ValidationResult::problem(sprintf('Valor não corresponde ao padrão: %s', $this->pattern));
    }
}
