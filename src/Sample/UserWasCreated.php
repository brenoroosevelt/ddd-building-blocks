<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes\IdentityOf;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DomainEvent;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid;

class UserWasCreated extends DomainEvent
{
    public function __construct(private string $userId)
    {
        parent::__construct();
    }

    public function userId(): string
    {
        return $this->userId;
    }

    #[IdentityOf(User::class)]
    public function getUserId(): Uuid
    {
        return Uuid::new($this->userId);
    }
}
