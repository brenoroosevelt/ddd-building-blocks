<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\DateTime;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\IntegerType;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample\Recent;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample\Today;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\StringType;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnum()
    {
        $obj1 = new ObjetoValor(new Class1("10"));
        $obj2 = new ObjetoValor(new Class1("10"));
        $this->assertTrue($obj1->equals($obj2));

        $x = new IntegerType(1);
        $this->assertTrue($x->equals(1));
    }
}
