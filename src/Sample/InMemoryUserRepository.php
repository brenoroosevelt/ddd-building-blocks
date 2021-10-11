<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\EntityCollectionTrait;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid;

class InMemoryUserRepository implements UserRepository
{
    const id = '25d1e05a-0f0f-46db-b52f-961be8f7e0bd';

    use EntityCollectionTrait;

    public function __construct(User ...$users)
    {
        $this->insert(...$users);
        $this->insert(new User(Uuid::new(self::id),'breno', true));
    }
}
