<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\PaginatedQuery;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Utility;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;

abstract class DoctrinePaginatedQuery implements PaginatedQuery
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function paginate(
        array $filters = [],
        array $orderBy = [],
        int $page = 1,
        int $perPage = self::DEFAULT_PER_PAGE
    ): PagerfantaInterface {
        $query = $this->queryBuilder();
        $query = $this->filters()->apply($query, $filters);
        $query = $this->sorting()->apply($query, $orderBy);
        $maxPerPage = $this->maxPerPage();
        $perPage = $maxPerPage !== null ? Utility::range($perPage, 1, $maxPerPage) : $perPage;
        return $this->pagination($query)->paginate($page, $perPage);
    }

    public abstract function queryBuilder(): QueryBuilder;

    public function filters(): Filter
    {
        return Filter::new();
    }

    public function sorting(): Sorting
    {
        return Sorting::new();
    }

    public function pagination($query): Pagination
    {
        return Pagination::query($query);
    }

    public function maxPerPage(): ?int
    {
        return null;
    }
}
