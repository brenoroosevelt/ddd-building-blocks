<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Comparison;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\SpecificationTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

class DateTime extends DateTimeImmutable
{
    use Comparison;
    use SpecificationTrait;

    protected function __construct($datetime = "now", $timezone = null)
    {
        parent::__construct($datetime, $timezone);
    }

    public static function createFromFormat($format, $datetime, DateTimeZone $timezone = null): self
    {
        $datetime = parent::createFromFormat($format, $datetime, $timezone);
        return new self($datetime->format(self::ISO8601), $timezone);
    }

    public static function now(): self
    {
        return new self();
    }

    public function __toString(): string
    {
        return $this->format(DATE_ISO8601);
    }

    public function equals($v): bool
    {
        return $this == $v;
    }
}
