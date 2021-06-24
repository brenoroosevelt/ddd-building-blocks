<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ValueObject;

class ObjetoValor extends ValueObject
{
    public Class1 $c;

    public function __construct(Class1 $c)
    {
        $this->c = $c;
    }
}
