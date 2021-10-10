<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\NotEmpty;

class ChangeName extends UserIdCommand
{
    #[NotEmpty]
    public ?string $name;
}
