<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ValueObject;
use DateTimeImmutable;
use DateTimeZone;

class DateTime extends ValueObject
{
    protected DateTimeImmutable $dateTime;

    protected function __construct(DateTimeImmutable $datetime)
    {
        $this->dateTime = $datetime;
    }

    public static function now(): self
    {
        return new self(new DateTimeImmutable());
    }

    public static function fromDate(int $year, int $month, int $day, int $hour = 0, int $min = 0, int $sec = 0): self
    {
        return new self(
            (new DateTimeImmutable)->setDate($year, $month, $day)->setDate($hour, $min, $sec)
        );
    }

    public static function fromFormat(string $format, string $dateTime,  DateTimeZone $timezone = null)
    {
        return new self(DateTimeImmutable::createFromFormat($format, $dateTime, $timezone));
    }

    public function format(string $format = DATE_ISO8601): string
    {
        return $this->dateTime->format($format);
    }

    public function toPrimitive(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function __toString(): string
    {
        return $this->format();
    }
}
