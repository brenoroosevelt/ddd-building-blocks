<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Application;

interface ApplicationService
{
    public function __invoke(Command $command = null);
}