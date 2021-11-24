<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine\DoctrinePaginatedQuery;
use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine\Filter;
use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine\Order;
use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine\Sorting;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class DoctrineUserQuery extends DoctrinePaginatedQuery implements UserQuery
{
    const MAX_PER_PAGE = 500;

    public function __construct(private EntityManager $entityManager)
    {
    }

    public function queryBuilder(): QueryBuilder
    {
        return
            $this->entityManager
                ->createQueryBuilder()
                ->select('u')
                ->from(User::class, 'u');
    }

    public function filters(): Filter
    {
        return
            Filter::new()
                ->add(
                    'name',
                    fn(QueryBuilder $qb, $value, array $filters) => Filter::like($qb, 'u.name', $value)
                );
    }

    public function sorting(): Sorting
    {
        return
            Sorting::new()
                ->add('name', 'u.name')
                ->setDefault(Order::by('name', Order::ASC));
    }

    public function maxPerPage(): ?int
    {
        return self::MAX_PER_PAGE;
    }
}
