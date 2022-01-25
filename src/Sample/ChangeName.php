<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DataTransferObject;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\FullName;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;
use BrenoRoosevelt\Specification\Spec\In;
use BrenoRoosevelt\Specification\Spec\IsNull;
use BrenoRoosevelt\Specification\Spec\NotEquals;
use OniBus\Command\Command;

class ChangeName extends DataTransferObject implements Command
{
    use UserIdTrait;

    #[Rule([In::class, ['M', 'F']], 'nome deve ser completo')]
    public ?string $name;
}
