<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

interface ObjectParameterIdentifiable
{
    public function identityOf(string $entity);
}
