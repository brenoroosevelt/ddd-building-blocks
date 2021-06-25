<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use Generator;

final class EventProvider
{
    private static ?self $instance = null;
    private array $events;

    public function recordEvent(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /** @return Generator|DomainEvent[] */
    public function releaseEvents(): Generator
    {
        while ($event = array_shift($this->events)) {
            yield $event;
        }
    }

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    private function __construct() {}
}
