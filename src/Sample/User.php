<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\AggregateRoot;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes\WithRepository;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\NotEmpty;
use OniBus\Attributes\CommandHandler;

#[WithRepository(UserRepository::class)]
class User extends AggregateRoot
{
    private Uuid $userId;
    private string $name;
    private bool $active;

    public function __construct(Uuid $userId, string $name, bool $active)
    {
        $this->userId = $userId;
        $this->setName($name);
        $this->active = $active;
        $this->recordThat(new UserWasCreated((string) $this->userId));
    }

    #[CommandHandler]
    public static function newUser(CreateUser $command): self
    {
        return new self(Uuid::new(), $command->name, true);
    }

    #[CommandHandler]
    public function changeName(ChangeName $command, UserRepository $repository): void
    {
        $this->setName($command->name);
    }

    #[CommandHandler]
    public function deactivate(DeactivateUser $command): void
    {
        $this->active = false;
        $this->recordThat(new UserWasDeactivated((string) $this->userId));
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

    public function getId(): Identity
    {
        return $this->userId;
    }
}
