<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Sample;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\DataTransferObject;
use OniBus\Event\Event;

class UserWasCreated extends DataTransferObject implements Event
{
   use UserIdTrait;
}
