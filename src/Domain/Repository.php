<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

interface Repository
{
    public function ofId($id);
    public function save($entity);
}
