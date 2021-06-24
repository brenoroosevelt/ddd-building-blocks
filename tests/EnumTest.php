<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\DateTime;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample\Recent;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Sample\Today;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnum()
    {
        $st = Status::ATIVO();
        $st1 = new Status('ativo');
        $this->assertTrue($st->equals($st1));
    }
}
