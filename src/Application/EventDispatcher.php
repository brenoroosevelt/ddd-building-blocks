<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Application;

use OniBus\Event\EventManager;
use OniBus\Message;

class EventDispatcher extends Dispatcher
{
    public function dispatch(Message $message)
    {
        $result = $this->next($message);
        foreach (EventManager::release() as $domainEvent) {
            parent::dispatch($domainEvent);
        }

        return $result;
    }

    protected function noHandlersFound(string $messageName): void
    {
    }
}
