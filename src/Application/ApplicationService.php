<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Application;

interface ApplicationService
{
    /** @return mixed */
    public function __invoke(Command $command = null);
}
