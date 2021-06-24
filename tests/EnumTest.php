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
        var_dump(Status::onlyValues());
        $st1 = new Status('ativo');
        $this->assertTrue($st->equals(Status::ATIVO));
    }

    public function testDateTime()
    {
        $data = DateTime::createFromFormat('d/m/Y H:i:s', '05/05/2021 10:15:00');
        var_dump($data);
        $this->assertTrue($data->is(new Today()));
        $this->assertTrue($data->is(new Recent(5)));
    }
}
