<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use DateTimeImmutable;

abstract class DomainEvent implements Identifiable
{
    private DateTimeImmutable $occurredOn;
    private Identity $eventId;

    public function __construct(?DateTimeImmutable $dateTime = null, ?Identity $eventId = null)
    {
        $this->occurredOn = $dateTime ?? new DateTimeImmutable();
        $this->eventId = $eventId ?? Uuid::new();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function getId(): Identity
    {
        return $this->eventId;
    }
}
