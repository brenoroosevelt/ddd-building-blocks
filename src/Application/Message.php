<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Application;

use OniBus\NamedMessage;

class Message
{
    public static function withName(string $name): NamedMessage
    {
        return new class($name) implements NamedMessage {
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
