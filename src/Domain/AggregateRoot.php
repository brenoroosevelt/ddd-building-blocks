<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use OniBus\Event\Event;

abstract class AggregateRoot extends Entity
{
    protected function recordThat(Event $event): void
    {
        EventProvider::instance()->recordEvent($event);
    }
}
