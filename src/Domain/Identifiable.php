<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

interface Identifiable
{
    public function getId(): Identity;
}
