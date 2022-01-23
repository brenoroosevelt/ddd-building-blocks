<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Validator;
use DateTime;
use DateTimeImmutable;
use ReflectionProperty;

class DataTransferObject
{
    public function __construct(...$args)
    {
        if (is_array($args[0] ?? null)) {
            $args = $args[0];
        }

        $this->getValidator()->validateOrFail($args);
        foreach ($args as $name => $value) {
            $this->setValue($name, $value);
        }
    }

    private function setValue(string $property, $value): void
    {
        if (!property_exists($this, $property)) {
            return;
        }

        $reflectionProperty = new ReflectionProperty($this, $property);
        $type = $reflectionProperty->getType()?->getName();

        $this->{$property} = match ($type) {
            DateTimeImmutable::class => new DateTimeImmutable($value),
            DateTime::class => new DateTime($value),
            'int'       => (int) $value,
            'string'    => (string) $value,
            'float'     => (float) $value,
            'boolean'   => (bool) $value,
            'array'     => (array) $value,
            default     => $value,
        };
    }

    protected function getValidator(): Validator
    {
        return Validator::fromClass($this);
    }
}
