<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http;

use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Doctrine\Pagination;
use JsonSerializable;
use Pagerfanta\PagerfantaInterface;
use Psr\Http\Message\ServerRequestInterface;

class PaginatedCollection implements JsonSerializable
{
    const WRAPPER_KEY = 'data';

    public function __construct(
        private PagerfantaInterface $data,
        private ?ServerRequestInterface $request = null,
        private string $wrapperKey = self::WRAPPER_KEY
    ) {
    }

    public function jsonSerialize(): array
    {
        $pagination = new Pagination();

        $info = [
            $this->wrapperKey => $this->data->jsonSerialize(),
            'pagination' => $pagination->paginationInfo($this->data)
        ];

        if ($this->request instanceof ServerRequestInterface) {
            $info['pagination']['_links'] = $pagination->paginationLinks($this->data, $this->request);
        }

        return $info;
    }
}
