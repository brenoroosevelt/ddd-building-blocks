<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

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
            if (!$ruleSet->isRequired() && !array_key_exists($field, $data)) {
                continue;
            }

            $result[$field] = $ruleSet->validate($data[$field] ?? null, $context);
        }

        return array_filter($result, fn(Violations $v) => !$v->isOk());
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
