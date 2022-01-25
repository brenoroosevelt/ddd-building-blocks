<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Violations;

#[Attribute(Attribute::TARGET_PROPERTY)]
class AlwaysOk implements Constraint
{
    public function validate($input, array $context = []): Violations
    {
        return Violations::ok();
    }
}
