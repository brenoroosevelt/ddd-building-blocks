<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AlwaysOk;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotRequired extends AlwaysOk
{
}
