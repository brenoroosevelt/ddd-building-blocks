<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use Doctrine\ORM\QueryBuilder;

class Sorting
{
    public function __construct(private array $fields = [], private array $default = [])
    {
    }

    public function setOrderBy(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        array $orderBy
    ): QueryBuilder {
        $orderBy =
            array_filter($orderBy, fn($v, $i) => array_key_exists($i, $this->fields), ARRAY_FILTER_USE_BOTH);

        $orderBy = !empty($orderBy) ? $orderBy : $this->default;
        foreach ($orderBy as $alias => $direction) {
            $direction =
                match (mb_strtolower((string) $direction)) {
                    'desc' => 'desc',
                    default => 'asc'
                };

            $field = $this->fields[$alias];
            $queryBuilder = $queryBuilder->orderBy($field, $direction);
        }

        return $queryBuilder;
    }
}
