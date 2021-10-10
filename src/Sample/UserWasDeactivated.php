<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DomainEvent;

class UserWasDeactivated extends DomainEvent
{
    public function __construct(private string $userId)
    {
        parent::__construct();
    }

    public function userId(): string
    {
        return $this->userId;
    }
}