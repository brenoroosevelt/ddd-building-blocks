<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use ReflectionClass;

class Validator
{
    /** @var RuleSet[]  */
    private array $ruleSets = [];

    public static function new(): self
    {
        return new self();
    }

    public function field(string $field): RuleSet
    {
        return $this->ruleSets[$field] ?? $this->ruleSets[$field] = new RuleSet();
    }

    public function only(string ...$fields): self
    {
        $instance = clone $this;
        foreach ($instance->ruleSets as $field => $ruleSet) {
            if (!in_array($field, $fields)) {
                unset($instance->ruleSets[$field]);
            }
        }

        return $instance;
    }

    public function except(string ...$fields): self
    {
        $instance = clone $this;
        foreach ($fields as $field) {
            unset($instance->ruleSets[$field]);
        }

        return $instance;
    }

    /**
     * @param array $data
     * @param array $context
     * @return Violations[]
     */
    public function validate(array $data, array $context = []): array
    {
        $result = [];
        foreach ($this->ruleSets as $field => $ruleSet) {
            if (!$ruleSet->isRequired() && !array_key_exists($field, $data)) {
                continue;
            }

            $result[$field] = $ruleSet->validate($data[$field] ?? null, $context);
        }

        return array_filter($result, fn(Violations $v) => !$v->isOk());
    }

    public function validateOrFail(array $data, array $context = []): void
    {
        $violations = $this->validate($data, $context);
        if (!empty($violations)) {
            throw new ValidationErrors($violations);
        }
    }

    public static function fromClass(string|object $objectOrClass): self
    {
        $instance = new self;
        foreach((new ReflectionClass($objectOrClass))->getProperties() as $property) {
            $instance->ruleSets[$property->getName()] = RuleSet::fromReflectionProperty($property);
        }

        $instance->ruleSets = array_filter($instance->ruleSets, fn(RuleSet $c) => !$c->isEmpty());
        return $instance;
    }
}
