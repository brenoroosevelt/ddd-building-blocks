<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Enum;

/**
 * Class Status
 * @method static Status ATIVO()
 * @method static Status INATIVO()
 */
class Status extends Enum
{
    const ATIVO = 'ativo';
    const INATIVO = 'inativo';
}
