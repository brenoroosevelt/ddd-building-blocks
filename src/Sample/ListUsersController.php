<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http\Collection;
use BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http\Input;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListUsersController
{
    public function __construct(private UserQuery $userQuery)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): ResponseInterface
    {
        $input = new Input($request);
        $users =
            $this->userQuery->paginate(
                $input->get('filter', []),
                $input->get('sort', []),
                $input->getInt('page', 1),
                $input->getInt('limit', UserQuery::DEFAULT_PER_PAGE)
            );

        return new JsonResponse(new Collection($users, $request));
    }
}
