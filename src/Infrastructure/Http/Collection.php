<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http;

use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine\Pagination;
use JsonSerializable;
use Pagerfanta\PagerfantaInterface;
use Psr\Http\Message\ServerRequestInterface;

class Collection implements JsonSerializable
{
    const WRAPPER_DATA_KEY = 'data';
    const WRAPPER_PAGINATION_KEY = 'pagination';
    const WRAPPER_LINKS_KEY = '_links';

    public function __construct(
        private $data,
        private ?ServerRequestInterface $request = null,
        private string $wrapperDataKey = self::WRAPPER_DATA_KEY,
        private string $wrapperPaginationKey = self::WRAPPER_PAGINATION_KEY,
        private string $wrapperPaginationLinksKey = self::WRAPPER_LINKS_KEY
    ) {
    }

    public function jsonSerialize(): array
    {
        $info[$this->wrapperDataKey] = $this->data;
        if ($this->data instanceof PagerfantaInterface) {
            $info[$this->wrapperPaginationKey] = Pagination::paginationInfo($this->data);

            if ($this->request instanceof ServerRequestInterface) {
                $info[$this->wrapperPaginationKey][$this->wrapperPaginationLinksKey] =
                    Pagination::paginationLinks($this->data, $this->request);

                $info['filter'] = $this->request->getQueryParams()['filter'] ?? [];
                $info['sort'] = $this->request->getQueryParams()['sort'] ?? [];
            }
        }

        return $info;
    }
}
