<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotRequired extends AlwaysOk
{
}
