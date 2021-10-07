<?php


namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Samples;


use BrenoRoosevelt\DDD\BuildingBlocks\Domain\AggregateRoot;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Entity;
use DomainException;
use PharIo\Manifest\Email;

final class User extends AggregateRoot
{
    private Email $email;
    private string $name;
    private bool $active;

    public function __construct(UserId $id, string $name, Email $email)
    {
        $this->setIdentity($id);
        $this->setName($name);
        $this->email = $email;
        $this->active = true;

        $this->recordThat(new UserRegistered($this->name, (string) $this->email));
    }

    public function changeEmail(string $email): void
    {
        if (!$this->active) {
            throw new DomainException("Inactive user cannot be changed.");
        }

        $this->email = new Email($email);
    }

    private function setName(string $name): void
    {
        if (!empty(trim($name))) {
            throw new DomainException("Name cannot be left empty.");
        }

        $this->name = $name;
    }
}