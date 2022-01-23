<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Email extends AbstractRule
{
    public function __construct(string $message = 'E-mail inválido')
    {
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return
            is_string($input) &&
            filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }
}
