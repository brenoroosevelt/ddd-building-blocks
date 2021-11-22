<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Exception\EntityNotFound;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Repository;
use Doctrine\ORM\EntityManager;

abstract class DoctrineRepository implements Repository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function ofId($id)
    {
        $entityClass = $this->entityClass();
        $entity = $this->entityManager->find($entityClass, $id);
        if (! $entity instanceof $entityClass) {
            throw EntityNotFound::forIdentity($id);
        }

        return $entity;
    }

    public function save($entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public abstract function entityClass(): string;
}
