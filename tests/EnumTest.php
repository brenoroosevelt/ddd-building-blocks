<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\DateTime;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Email;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\IntegerValue;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\StringValue;
use PHPUnit\Framework\TestCase;
use function BrenoRoosevelt\Specification\between;
use function BrenoRoosevelt\Specification\equals;
use function BrenoRoosevelt\Specification\length;
use function BrenoRoosevelt\Specification\same;

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
