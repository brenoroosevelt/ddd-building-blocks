<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Check;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\NotRequired;
use ReflectionAttribute;
use ReflectionProperty;

class RuleSet implements Rule
{
    /** @var Rule[] */
    private array $rules;

    final public function __construct(Rule ...$rule)
    {
        $this->rules = $rule;
    }

    public static function new(): self
    {
        return new self();
    }

    public function add(Rule ...$rules): self
    {
        array_push($this->rules, ...$rules);
        return $this;
    }

    public function verify(callable $fn, string $message): self
    {
        $this->rules[] = new Check($fn, $message);
        return $this;
    }

    public function notRequired(): self
    {
        $this->rules[] = new NotRequired;
        return $this;
    }

    public function validate($input, array $context = []): Violations
    {
        $violations = Violations::ok();
        foreach ($this->rules as $constraint) {
            $violations = $violations->add(...$constraint->validate($input, $context)->getErrors());
        }

        return $violations;
    }

    public function validateOrFail($data, array $context = []): void
    {
        $this->validate($data, $context)->guard();
    }

    public function isRequired(): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        foreach ($this->rules as $constraint) {
            if ($constraint instanceof NotRequired) {
                return false;
            }
        }

        return true;
    }

    public function isEmpty(): bool
    {
        return empty($this->rules);
    }

    public static function fromProperty(string|object $objectOrClass, string $property): self
    {
        return self::fromReflectionProperty((new ReflectionProperty($objectOrClass, $property)));
    }

    public static function fromReflectionProperty(ReflectionProperty $property): self
    {
        return new self(
            ...array_map(
                fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
                $property->getAttributes(Rule::class, ReflectionAttribute::IS_INSTANCEOF)
            )
        );
    }
}
