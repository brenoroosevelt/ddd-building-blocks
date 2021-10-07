<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Exception;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use DomainException;

class EntityNotFound extends DomainException
{
    public static function forIdentity(Identity $identity): self
    {
        return new self(
            sprintf(
                "Entity not found [id=%s]",
                (string) $identity
            ),
            404
        );
    }
}
