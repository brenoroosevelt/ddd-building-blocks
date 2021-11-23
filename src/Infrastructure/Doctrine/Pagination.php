<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pagination
{
    const DEFAULT_LIMIT = 25;

    public function paginate(
        Query|QueryBuilder $query,
        int $page,
        int $limit = self::DEFAULT_LIMIT,
        bool $allowOutOfRangePages = true,
        bool $fetchJoinCollection = true,
        ?bool $useOutputWalkers = null
    ): PagerfantaInterface {
        if ($page < 1) {
            $page = 1;
        }
        
        $adapter = new QueryAdapter($query, $fetchJoinCollection, $useOutputWalkers);
        $pager = new Pagerfanta($adapter);
        $pager->setAllowOutOfRangePages($allowOutOfRangePages);
        $pager->setCurrentPage($page);
        $pager->setMaxPerPage($limit);

        return $pager;
    }

    public function paginationInfo(PagerfantaInterface $data): array
    {
        return [
            'page' => $data->getCurrentPage(),
            'limit' => $data->getMaxPerPage(),
            'total_pages' => $data->getNbPages(),
            'total_results' => $data->getNbResults(),
            'page_results' => count($data->getCurrentPageResults()),
            'next_page' => $data->hasNextPage() ? $data->getNextPage() : null,
            'previous_page' => $data->hasPreviousPage() ? $data->getPreviousPage() : null,
        ];
    }

    public function paginationLinks(PagerfantaInterface $data, ServerRequestInterface $request): array
    {
        $current = $data->getCurrentPage();
        $prev = $current - 1;
        $next = $current + 1;
        $last = $data->getNbPages();

        return [
            'self' => $this->getPageLink($current, $request),
            'first' => $this->getPageLink(1, $request),
            'last' => $last ? $this->getPageLink($last, $request) : null,
            'prev' => $prev ? $this->getPageLink($prev, $request) : null,
            'next' => $next <= $last ? $this->getPageLink($next, $request) : null,
        ];
    }

    protected function getPageLink(int $page, ServerRequestInterface $request): string
    {
        $query = array_merge($request->getQueryParams(), ['page' => $page]);
        return $request->getUri()->getPath() . '?' . http_build_query($query);
    }
}
