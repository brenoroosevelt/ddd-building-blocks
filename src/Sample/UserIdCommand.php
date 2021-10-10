<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DataTransferObject;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identifiable;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identity;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Uuid;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Uuid as Id;
use OniBus\Command\Command;

class UserIdCommand extends DataTransferObject implements Command, Identifiable
{
    #[Uuid]
    public string $id;

    public function getId(): Identity
    {
        return Id::new($this->id);
    }
}
