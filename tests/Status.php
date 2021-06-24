<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Test;

use BrenoRoosevelt\DddBuildingBlocks\Domain\Support\Enum;

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
