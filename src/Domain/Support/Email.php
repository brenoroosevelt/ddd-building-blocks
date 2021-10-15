<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Email as EmailValidation;

class Email extends StringLiteral
{
    public function getValidation(): Constraint
    {
        return new EmailValidation();
    }
}
