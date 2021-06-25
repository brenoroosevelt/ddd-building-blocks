<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification\Specification;

class EntityCollection
{
    /**
     * @var Entity[]
     */
    private array $elements;

    final public function __construct(Entity ...$entities)
    {
        foreach ($entities as $entity) {
            $this->elements[(string) $entity->getId()] = $entity;
        }
    }

    /** @return static */
    public function add(Entity $entity)
    {
        return static($this->elements + $entity);
    }

    /** @return static */
    public function remove(Entity $entity)
    {
        $elements = $this->elements;
        unset($elements[(string) $entity->getId()]);
        return static($elements);
    }

    /** @return static */
    public function match(Specification $specification)
    {
        $matched =
            array_filter(
                $this->elements,
                fn (Entity $entity) => $specification->isSatisfiedBy($entity)
            );

        return new static(...$matched);
    }

    public function has(Entity $entity): bool
    {
        $id = (string) $entity->getId();
        return array_key_exists($id, $this->elements);
    }

    public function byId(Identity $identity)
    {
        return $this->elements[(string) $identity] ?? null;
    }

    public function hasId(Identity $identity): bool
    {
        return $this->byId($identity) instanceof Entity;
    }

    public function all(): array
    {
        return $this->elements;
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function isEmpty(): bool
    {
        return (bool) $this->count();
    }
}
