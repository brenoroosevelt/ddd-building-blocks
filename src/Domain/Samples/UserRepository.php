<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Samples;

interface UserRepository {
    public function ofId(UserId $id): User;
    public function save(User $user): void;
    public function delete(User $user): void;
    public function count(): int;
}
