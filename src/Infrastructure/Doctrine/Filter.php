<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use Doctrine\ORM\QueryBuilder;

class Filter
{
    private function __construct(private array $fields = [])
    {
    }

    public static function new(array $fields = []): self
    {
        return new self($fields);
    }

    public function add(string $alias, callable $fn): self
    {
        $this->fields[$alias] = $fn;
        return $this;
    }

    public function apply(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        array $filters = []
    ): QueryBuilder {
        foreach ($filters as $alias => $value) {
            $filter = $this->fields[$alias] ?? fn ($q, $v, $f) => $q;
            $queryBuilder = $filter($queryBuilder, $value, $filters);
        }

        return $queryBuilder;
    }

    public static function like(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        string $field,
        string $value
    ): \Doctrine\DBAL\Query\QueryBuilder|QueryBuilder {
        $paramName = 'p_' . md5(uniqid());
        return $queryBuilder->where("$field LIKE $paramName")
            ->setParameter($paramName, '%' . addcslashes($value, '%_') . '%');
    }
}
