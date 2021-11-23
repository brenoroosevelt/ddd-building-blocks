<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use Doctrine\ORM\QueryBuilder;

class OrderBy
{
    public function __construct(private array $allowedFields = [], private array $default = [])
    {
    }

    private function setOrderBy(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        array $orderBy
    ): QueryBuilder {
        $orderBy =
            array_filter($orderBy, fn($v, $i) => in_array($i, $this->allowedFields), ARRAY_FILTER_USE_BOTH);

        $orderBy = !empty($orderBy) ? $orderBy : $this->default;
        foreach ($orderBy as $field => $direction) {
            $direction =
                match (mb_strtolower((string) $direction)) {
                    'desc' => 'desc',
                    default => 'asc'
                };

            $queryBuilder = $queryBuilder->orderBy($field, $direction);
        }

        return $queryBuilder;
    }
}