<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;
use BrenoRoosevelt\Specification\Spec\IsNull;
use BrenoRoosevelt\Specification\Spec\Not;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotNull extends Rule
{
    public function __construct(string $message = 'Este valor não pode ser nulo')
    {
        parent::__construct(new Not(new IsNull), $message);
    }
}
