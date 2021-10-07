<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Application\Role;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Specification\Spec;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\DateTime;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\IntegerValue;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample\Recent;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample\Today;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\StringValue;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnum()
    {
        $obj1 = new ObjetoValor(new Class1("10"));
        $obj2 = new ObjetoValor(new Class1("10"));
        $this->assertTrue($obj1->equals($obj2));

        $x = new IntegerValue(1);
        $this->assertTrue($x->equals(1));

        $role = Role::SECRETARIA();
    }
}
