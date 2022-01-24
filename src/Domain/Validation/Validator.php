<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\NotRequired;

class Validator
{
    /** @var RuleSet[] */
    private array $ruleSets = [];

    final public function __construct(array $ruleSets = [])
    {
        $this->ruleSets = array_filter($ruleSets, fn($item) => $item instanceof RuleSet);
    }

    public static function new(): self
    {
        return new self;
    }

    public function field(string $field): RuleSet
    {
        return $this->ruleSets[$field] ?? $this->ruleSets[$field] = new RuleSet();
    }

    /** @return Violations[] */
    public function validate(array $data, array $context = []): array
    {
        $result = [];
        foreach ($this->ruleSets as $field => $ruleSet) {
            if (!$this->isRequired($field) && !array_key_exists($field, $data)) {
                continue;
            }

            $result[$field] = $ruleSet->validate($data[$field] ?? null, $context);
        }

        return array_filter($result, fn(Violations $v) => !$v->isOk());
    }

    public function isRequired(string $field): bool
    {
        if ($this->field($field)->isEmpty()) {
            return false;
        }

        foreach ($this->field($field) as $constraint) {
            if ($constraint instanceof NotRequired) {
                return false;
            }
        }

        return true;
    }

    public function validateOrFail(array $data, array $context = [], string $message = null): void
    {
        $violations = $this->validate($data, $context);
        if (!empty($violations)) {
            throw new ValidationErrors($violations, $message);
        }
    }

    public static function fromClass(string|object $objectOrClass): self
    {
        return new self(RuleSet::fromClass($objectOrClass));
    }
}
