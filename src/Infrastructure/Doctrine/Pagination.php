<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\DBAL\SingleTableQueryAdapter;
use Pagerfanta\Doctrine\DBAL\QueryAdapter as DBALQueryAdapter;
use Doctrine\DBAL\Query\QueryBuilder as DBALQueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pagination
{
    const DEFAULT_LIMIT = 25;

    public function __construct(private AdapterInterface $adapter)
    {
    }

    public static function query(
        QueryBuilder|Query $query,
        bool $fetchJoinCollection = true,
        ?bool $useOutputWalkers = null
    ): Pagination {
        $adapter = new QueryAdapter($query, $fetchJoinCollection, $useOutputWalkers);
        return new Pagination($adapter);
    }

    public static function queryDBAL(
        DBALQueryBuilder $query,
        string $countField
    ): Pagination {
        $joins = $query->getQueryPart('join');
        $hasQueryBuilderJoins = !empty($joins);

        $adapter =
            $hasQueryBuilderJoins ?
                new DBALQueryAdapter(
                    $query,
                    function(DBALQueryBuilder $qb) use ($countField) {
                        return $qb
                            ->select("COUNT(DISTINCT $countField) AS total_results")
                            ->setMaxResults(1);
                    }
                ) :
                new SingleTableQueryAdapter($query, $countField);

        return new Pagination($adapter);
    }

    public function paginate(
        int $page,
        int $limit = self::DEFAULT_LIMIT,
        bool $allowOutOfRangePages = true
    ): PagerfantaInterface {
        if ($page < 1) {
            $page = 1;
        }

        $pager = new Pagerfanta($this->adapter);
        $pager->setAllowOutOfRangePages($allowOutOfRangePages);
        $pager->setCurrentPage($page);
        $pager->setMaxPerPage($limit);

        return $pager;
    }

    public static function paginationInfo(PagerfantaInterface $data): array
    {
        return [
            'page' => $data->getCurrentPage(),
            'limit' => $data->getMaxPerPage(),
            'total_pages' => $data->getNbPages(),
            'total_results' => $data->getNbResults(),
            'next_page' => $data->hasNextPage() ? $data->getNextPage() : null,
            'previous_page' => $data->hasPreviousPage() ? $data->getPreviousPage() : null,
        ];
    }

    public static function paginationLinks(PagerfantaInterface $data, ServerRequestInterface $request): array
    {
        $current = $data->getCurrentPage();
        $last = $data->getNbPages();

        return [
            'self' => self::getPageLink($current, $request),
            'first' => self::getPageLink(1, $request),
            'last' => self::getPageLink($data->getNbPages(), $request),
            'prev' => $data->hasPreviousPage() ? self::getPageLink($data->getPreviousPage(), $request) : null,
            'next' => $data->hasNextPage() ? self::getPageLink($data->getNextPage(), $request) : null,
        ];
    }

    public static function getPageLink(int $page, ServerRequestInterface $request): string
    {
        $query = array_merge($request->getQueryParams(), ['page' => $page]);
        return $request->getUri()->getPath() . '?' . http_build_query($query);
    }
}
