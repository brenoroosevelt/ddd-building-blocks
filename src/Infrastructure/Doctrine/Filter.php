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
        string $value,
        bool $split = false
    ): \Doctrine\DBAL\Query\QueryBuilder|QueryBuilder {

        $values = $split ? explode(' ', $value) : $value;
        foreach ($values as $value) {
            $paramName = 'p_' . md5(uniqid());
            $queryBuilder = $queryBuilder->andWhere("$field LIKE :$paramName")
                ->setParameter($paramName, '%' . addcslashes($value, '%_') . '%');
        }

        return $queryBuilder;
    }

    public static function in(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        string $field,
        array $values
    ): \Doctrine\DBAL\Query\QueryBuilder|QueryBuilder {
        $paramName = 'p_' . md5(uniqid());
        return $queryBuilder->andWhere("$field IN (:$paramName)")
            ->setParameter($paramName, $values);
    }
}
