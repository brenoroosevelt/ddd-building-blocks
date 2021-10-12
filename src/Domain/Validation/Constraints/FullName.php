<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FullName extends AbstractConstraint
{
    protected static string $defaultMessage = 'Nome deve ser completo';

    public function validate($input, array $context = []): ValidationResult
    {
        return
            is_string($input) &&
            count(explode(' ', $input)) > 1 &&
            mb_strlen($input) >= 5 ?
                $this->ok() :
                $this->error();
    }
}
