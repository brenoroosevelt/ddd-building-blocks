<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use OniBus\Event\Event;
use OniBus\Event\EventManager;

abstract class AggregateRoot extends Entity
{
    protected function recordThat(Event $event): void
    {
        EventManager::eventProvider()->recordEvent($event);
    }
}
