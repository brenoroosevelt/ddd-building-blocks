<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractConstraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotNull extends AbstractConstraint
{
    public function __construct(string $message = 'Este valor não pode ser nulo')
    {
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return null !== $input;
    }
}
