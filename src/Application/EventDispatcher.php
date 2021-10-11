<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Application;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\EventProvider;
use OniBus\Message;

class EventDispatcher extends Dispatcher
{
    public function dispatch(Message $message)
    {
        $result = $this->next($message);
        foreach (EventProvider::instance()->releaseEvents() as $domainEvent) {
            parent::dispatch($domainEvent);
        }

        return $result;
    }

    protected function noHandlersFound(string $messageName): void
    {
    }
}
