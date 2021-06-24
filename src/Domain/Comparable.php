<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain;

interface Comparable
{
    public function equals($v): bool;
}
