<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

class Class1
{
    public string $valor;

    public function __construct(string $valor)
    {
        $this->valor = $valor;
    }
}
