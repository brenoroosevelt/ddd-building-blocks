<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use Attribute;
use UnexpectedValueException;

#[Attribute(Attribute::TARGET_CLASS)]
class UseRepository
{
    public function __construct(public string $repository)
    {
        if (!is_subclass_of($this->repository, Repository::class, true)) {
            throw new UnexpectedValueException(
                sprintf('Invalid repository class: %s', $this->repository)
            );
        }
    }
}
