<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Test;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnum()
    {
        $st = Status::ATIVO();
        var_dump(Status::onlyValues());
        $st1 = new Status('ativo');
        $this->assertTrue($st->equals(Status::ATIVO));
    }
}
