<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Entity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification\Specification;
use DomainException;
use Exception;

trait EntitiesInMemory
{
    protected array $entities;

    protected function ofId(Identity $id)
    {
        if (!array_key_exists((string) $id, $this->entities)) {
            throw $this->notFoundException($id);
        }

        return $this->entities[(string) $id];
    }

    protected function put(Entity ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->entities[(string) $entity->getId()] = $entity;
        }
    }

    protected function delete(Entity $entity): void
    {
        unset($this->entities[(string) $entity->getId()]);
    }

    protected function count(): int
    {
        return count($this->entities);
    }

    protected function all(): array
    {
        return array_values($this->entities);
    }

    protected function match(Specification $specification): array
    {
        $matched =
            array_filter(
                $this->entities,
                fn (Entity $entity) => $specification->isSatisfiedBy($entity)
            );

        return array_values($matched);
    }

    protected function notFoundException(Identity $identity): Exception
    {
        return new DomainException(
            sprintf(
                "[%s] Entity not found [id=%s]",
                static::class,
                (string) $identity
            )
        );
    }
}
