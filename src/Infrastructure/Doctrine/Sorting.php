<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use Doctrine\ORM\QueryBuilder;

class Sorting
{
    private function __construct(private array $fields = [], private array $default = [])
    {
    }

    public static function new(array $fields = []): self
    {
        return new self($fields);
    }

    public function add(string $alias, string $field): self
    {
        $this->fields[$alias] = $field;
        return $this;
    }

    public function addDefault(string $alias, string $direction = 'asc'): self
    {
        $this->default[$alias] = $this->parseDirection($direction);
        return $this;
    }

    public function setDefault(array $default): self
    {
        $this->default = $default;
        return $this;
    }

    public function apply(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        array $orderBy = []
    ): QueryBuilder {
        $orderBy = !empty($orderBy) ? $orderBy : $this->default;
        $orderBy =
            array_filter($orderBy, fn($v, $i) => array_key_exists($i, $this->fields), ARRAY_FILTER_USE_BOTH);

        foreach ($orderBy as $alias => $direction) {
            $direction =$this->parseDirection($direction);
            $field = $this->fields[$alias];
            $queryBuilder = $queryBuilder->orderBy($field, $direction);
        }

        return $queryBuilder;
    }

    private function parseDirection($direction): string
    {
        return
            match (mb_strtolower((string) $direction)) {
                'desc' => 'desc',
                default => 'asc'
            };
    }
}
