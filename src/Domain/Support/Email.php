<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

class Email extends StringLiteral
{
    public function validationRules(): Rule
    {
        return new Constraints\Email();
    }
}
