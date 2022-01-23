<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractConstraint;
use Ramsey\Uuid\Uuid as RamseyUuid;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Uuid extends AbstractConstraint
{
    public function __construct(string $message = 'Uuid inválido')
    {
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return RamseyUuid::isValid((string) $input);
    }
}
