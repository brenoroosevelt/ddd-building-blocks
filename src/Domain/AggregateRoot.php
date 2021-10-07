<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

abstract class AggregateRoot extends Entity
{
    protected function recordThat(DomainEvent $event): void
    {
        EventProvider::instance()->recordEvent($event);
    }
}
