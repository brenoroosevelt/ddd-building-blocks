<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Exception\EntityNotFound;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Repository;
use Doctrine\ORM\EntityManager;

abstract class DoctrineRepository implements Repository
{
    public function __construct(protected EntityManager $entityManager)
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
        $this->afterSave($entity);
    }

    protected function afterSave($entity): void
    {
        //$this->entityManager->flush();
    }

    public abstract function entityClass(): string;
}
