<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DataTransferObject;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\NotEmpty;
use OniBus\Command\Command;

class ChangeName extends DataTransferObject implements Command
{
    use UserIdTrait;

    #[NotEmpty]
    public ?string $name;
}
