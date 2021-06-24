<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use Generator;

final class EventProvider
{
    private static self $instance;
    private array $events;

    public function recordEvent(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function releaseEvents(): Generator
    {
        while ($event = array_shift($this->events)) {
            yield $event;
        }
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {}
}
