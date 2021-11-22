<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http;

use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine\Pagination;
use JsonSerializable;
use Pagerfanta\PagerfantaInterface;
use Psr\Http\Message\ServerRequestInterface;

class PaginatedCollection implements JsonSerializable
{
    const WRAPPER_DATA_KEY = 'data';
    const WRAPPER_PAGINATION_KEY = 'pagination';
    const WRAPPER_LINKS_KEY = '_links';

    public function __construct(
        private PagerfantaInterface $data,
        private ?ServerRequestInterface $request = null,
        private string $wrapperDataKey = self::WRAPPER_DATA_KEY,
        private string $wrapperPaginationKey = self::WRAPPER_PAGINATION_KEY,
        private string $wrapperPaginationLinksKey = self::WRAPPER_LINKS_KEY
    ) {
    }

    public function jsonSerialize(): array
    {
        $pagination = new Pagination();

        $info = [
            $this->wrapperDataKey => $this->data->jsonSerialize(),
            $this->wrapperPaginationKey => $pagination->paginationInfo($this->data)
        ];

        if ($this->request instanceof ServerRequestInterface) {
            $info[$this->wrapperPaginationKey][$this->wrapperPaginationLinksKey] =
                $pagination->paginationLinks($this->data, $this->request);
        }

        return $info;
    }
}
