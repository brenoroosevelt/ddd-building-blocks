<?php

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractConstraint;

class IsString extends AbstractConstraint
{
    public function __construct(string $message = 'Este valor deve ser um texto (string)')
    {
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return is_string($input);
    }
}
