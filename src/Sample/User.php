<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\AggregateRoot;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\UseRepository;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\NotEmpty;
use OniBus\Attributes\CommandHandler;

#[UseRepository(UserRepository::class)]
class User extends AggregateRoot
{
    private string $name;
    private bool $active;

    public function __construct(Identity $id, string $name, bool $active)
    {
        parent::__construct($id);
        $this->setName($name);
        $this->active = $active;
    }

    #[CommandHandler]
    public static function newUser(CreateUser $command): self
    {
        return new self(Uuid::new(), $command->name, true);
    }

    #[CommandHandler]
    public function changeName(ChangeName $command): void
    {
        $this->setName($command->name);
    }

    #[CommandHandler]
    public function deactivate(DeactivateUser $command): void
    {
        $this->active = false;
    }

    private function setName(string $name): void
    {
        (new NotEmpty)->validate($name)->guard();
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
