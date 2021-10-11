<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Entity;
use UnexpectedValueException;

#[Attribute(Attribute::TARGET_PROPERTY|Attribute::TARGET_METHOD)]
class IdentityOf
{
    public function __construct(public string $target)
    {
        if (!is_subclass_of($this->target, Entity::class, true)) {
            throw new UnexpectedValueException(
                sprintf('Invalid identity target class: %s', $this->target)
            );
        }
    }
}
