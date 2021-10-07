<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Entity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Exception\EntityNotFound;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\Specification\Specification;
use Exception;

trait EntitiesInMemory
{
    protected array $entities = [];

    public function ofId(Identity $id): Entity
    {
        if (!$this->hasId($id)) {
            throw $this->notFoundException($id);
        }

        return $this->entities[(string) $id];
    }

    public function add(Entity $entity): void
    {
        $this->put($entity);
    }

    protected function put(Entity ...$entities): void
    {
        foreach ($entities as $entity) {
            $this->entities[(string) $entity->getId()] = $entity;
        }
    }

    public function remove(Entity $entity): void
    {
        unset($this->entities[(string) $entity->getId()]);
    }

    public function count(): int
    {
        return count($this->entities);
    }

    public function isEmpty(): bool
    {
        return empty($this->entities);
    }

    public function has(Entity $entity): bool
    {
        return $this->hasId($entity->getId());
    }

    public function hasId(Identity $identity): bool
    {
        $id = (string) $identity;
        return array_key_exists($id, $this->entities);
    }

    public function all(): array
    {
        return array_values($this->entities);
    }

    /**
     * @param callable $fn
     * @return $this
     */
    public function filter(callable $fn)
    {
        $new = clone $this;
        $new->entities = array_filter($this->entities, $fn);
        return $new;
    }

    public function match(Specification $specification): array
    {
        $matched =
            array_filter(
                $this->entities,
                fn (Entity $entity) => $specification->isSatisfiedBy($entity)
            );

        return array_values($matched);
    }

    public function toArray(): array
    {
        return $this->entities;
    }

    public function notFoundException(Identity $identity): Exception
    {
        return EntityNotFound::forIdentity($identity);
    }
}
