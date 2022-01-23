<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Violations;

#[Attribute(Attribute::TARGET_PROPERTY)]
class AlwaysOk implements Rule
{
    public function validate($input, array $context = []): Violations
    {
        return Violations::ok();
    }
}
