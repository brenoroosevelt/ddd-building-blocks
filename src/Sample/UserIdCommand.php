<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes\IdentityOf;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DataTransferObject;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\UuidValidator;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid;
use OniBus\Command\Command;

class UserIdCommand extends DataTransferObject implements Command
{
    #[UuidValidator]
    public string $id;

    #[IdentityOf(User::class)]
    public function getUserId(): Uuid
    {
        return Uuid::new($this->id);
    }
}
