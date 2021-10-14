<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\AggregateRoot;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes\Handler;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes\WithRepository;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\FullName;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\NotEmpty;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Validation;

#[WithRepository(UserRepository::class)]
class User extends AggregateRoot
{
    private Uuid $userId;

    #[FullName]
    private string $name;

    private bool $active;

    public function __construct(Uuid $userId, string $name, bool $active)
    {
        $this->userId = $userId;
        $this->setName($name);
        $this->active = $active;
        $this->recordThat(new UserWasCreated(userId: (string) $this->userId));
    }

    #[Handler]
    public static function newUser(CreateUser $command): self
    {
        return new self(Uuid::new(), $command->name, true);
    }

    #[Handler]
    public function changeName(UserRepository $repository, ChangeName $command, ): void
    {
        $this->setName($command->name);
    }

    #[Handler(DeactivateUser::class)]
    public function deactivate(): void
    {
        $this->setActive(false);
        $this->recordThat(new UserWasDeactivated(userId: (string) $this->userId));
    }

    #[Handler]
    public static function whenUserWasCreated(UserWasCreated $command): void
    {
        //var_dump($command->getId());
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

    private function setName(string $name): void
    {
        $validation = new Validation(NotEmpty::class, 'O nome do usuário não pode ser vazio');
        $validation->validateOrFail($name);
        $this->name = $name;
    }

    private function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
