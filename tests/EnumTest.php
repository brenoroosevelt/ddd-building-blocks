<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Test;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnum()
    {
        $st = Status::ATIVO();
        $this->assertTrue($st->equals(Status::ATIVO));
    }
}
