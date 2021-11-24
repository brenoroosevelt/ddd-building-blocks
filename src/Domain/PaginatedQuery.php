<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

interface PaginatedQuery
{
    const DEFAULT_PER_PAGE = 25;

    public function paginate(
        array $filters = [],
        array $orderBy = [],
        int $page = 1,
        int $perPage = self::DEFAULT_PER_PAGE
    );
}
