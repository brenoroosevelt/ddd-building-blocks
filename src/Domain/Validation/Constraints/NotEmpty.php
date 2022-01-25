<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;
use BrenoRoosevelt\Specification\Spec\IsEmpty;
use BrenoRoosevelt\Specification\Spec\Not;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEmpty extends Rule
{
    public function __construct(string $message = 'Este valor não pode ficar vazio')
    {
        parent::__construct(new Not(new IsEmpty), $message);
    }
}
