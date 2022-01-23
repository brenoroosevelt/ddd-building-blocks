<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationErrors;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\AllowsEmpty;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Validation;
use ReflectionAttribute;
use ReflectionClass;

class Validator
{
    private array $rules = [];

    public static function new(): self
    {
        return new self();
    }

    public static function fromAttributes($objectOrClass, string $attribute = Rule::class): self
    {
        $instance = new self();
        foreach ((new ReflectionClass($objectOrClass))->getProperties() as $property) {
            $attributes = $property->getAttributes($attribute, ReflectionAttribute::IS_INSTANCEOF);
            $propertyValidations = array_map(fn(ReflectionAttribute $r) => $r->newInstance(), $attributes);
            foreach ($propertyValidations as $validation) {
                $instance->rules[$property->getName()][] = $validation;
            }
        }

        return $instance;
    }

    public static function property($objectOrClass, string $property): self
    {
        $instance = new self();
        $property = new \ReflectionProperty($objectOrClass, $property);
        $attributes = $property->getAttributes(Rule::class, ReflectionAttribute::IS_INSTANCEOF);
        $propertyValidations = array_map(fn(ReflectionAttribute $r) => $r->newInstance(), $attributes);
        foreach ($propertyValidations as $validation) {
            $instance->rules[$property->getName()][] = $validation;
        }

        return $instance;
    }

    public function add(string $name, $constraint, ?string $message = null): self
    {
        $this->rules[$name][] = new Validation($constraint, $message);
        return $this;
    }

    public function validate(array $data, array $only = []): Violations
    {
        $notification = Violations::ok();
        foreach ($this->rules as $name => $rules) {
            $value = $data[$name] ?? null;
            if ($this->allowsEmpty($name) && empty($value)) {
                continue;
            }

            if (!empty($only) && !in_array($name, $only)) {
                continue;
            }

            /** @var Rule $rule */
            foreach ($rules as $rule) {
                $result = $rule->validate($value, $data);
                $notification->fieldErrors($name, ...$result->messages());
            }
        }

        return $notification;
    }

    public function validateOrFail(array $data, array $only = []): void
    {
        $result = $this->validate($data, $only);
        if ($result->hasErrors()) {
            throw new ValidationErrors($result->getErrors());
        }
    }

    private function allowsEmpty($name): bool
    {
        foreach ($this->rules[$name] ?? [] as $validation) {
            if ($validation instanceof AllowsEmpty) {
                return true;
            }
        }

        return false;
    }
}
