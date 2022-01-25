<?php

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsString extends Rule
{
    public function __construct(string $message = 'Este valor deve ser um texto (string)')
    {
        parent::__construct('is_string', $message);
    }
}
