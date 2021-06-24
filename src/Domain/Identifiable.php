<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Domain;

interface Identifiable
{
    public function getId(): Identity;
}
