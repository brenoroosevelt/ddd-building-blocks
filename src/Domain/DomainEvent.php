<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use DateTimeImmutable;

abstract class DomainEvent
{
    private DateTimeImmutable $occurredOn;

    protected function resetOccurredOn(DateTimeImmutable $dateTime = null)
    {
        $this->occurredOn = $dateTime ?? new DateTimeImmutable();
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
