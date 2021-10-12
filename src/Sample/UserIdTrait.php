<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes\IdentityOf;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\UuidValidator;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid;

trait UserIdTrait
{
    #[UuidValidator]
    public string $userId;

    #[IdentityOf(User::class)]
    public function getUserId(): Uuid
    {
        return Uuid::new($this->userId);
    }
}
