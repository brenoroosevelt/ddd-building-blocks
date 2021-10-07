<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

#[Attribute(Attribute::TARGET_PROPERTY)]
class InList implements Constraint
{
    public function __construct(private array $list)
    {
    }

    public function validate($input, array $context = []): ValidationResult
    {
        return
            in_array($input, $this->list, true) ?
                ValidationResult::ok() :
                $this->error();
    }

    private function error(): ValidationResult
    {
        $acceptable = implode(', ', $this->list);
        return ValidationResult::problem("Os valores permitidos são: $acceptable");
    }
}
