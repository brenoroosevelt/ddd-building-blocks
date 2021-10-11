<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Handler
{
    public function __construct(public ?string $message = null)
    {
    }
}
