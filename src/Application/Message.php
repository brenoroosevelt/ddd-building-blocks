<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Application;

use OniBus\Command\Command;
use OniBus\Event\Event;
use OniBus\NamedMessage;
use OniBus\Query\Query;

class Message
{
    public static function event(string $name): Event
    {
        return new class($name) implements NamedMessage, Event {
            private $name;

            public function __construct($name)
            {
                $this->name = $name;
            }

            public function getMessageName(): string
            {
                return $this->name;
            }
        };
    }

    public static function command(string $name): Command
    {
        return new class($name) implements NamedMessage, Command {
            private $name;

            public function __construct($name)
            {
                $this->name = $name;
            }

            public function getMessageName(): string
            {
                return $this->name;
            }
        };
    }

    public static function query(string $name): Query
    {
        return new class($name) implements NamedMessage, Query {
            private $name;

            public function __construct($name)
            {
                $this->name = $name;
            }

            public function getMessageName(): string
            {
                return $this->name;
            }
        };
    }
}
