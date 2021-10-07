<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use DateTimeImmutable;

abstract class DomainEvent
{
    private DateTimeImmutable $occurredOn;
    private Identity $id;

    public function __construct(?DateTimeImmutable $dateTime = null, ?Identity $id = null)
    {
        $this->occurredOn = $dateTime ?? new DateTimeImmutable();
        $this->id = $id ?? Uuid::new();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function id(): string
    {
        return (string) $this->id;
    }
}
