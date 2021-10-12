<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DataTransferObject;
use OniBus\Command\Command;

class DeactivateUser extends DataTransferObject implements Command
{
    use UserIdTrait;
}
