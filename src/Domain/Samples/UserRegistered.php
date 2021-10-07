<?php


namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Samples;


use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DomainEvent;

final class UserRegistered extends DomainEvent
{
    private string $name;
    private string $email;

    public function __construct(string $name, string $email)
    {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}