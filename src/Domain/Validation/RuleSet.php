<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

/**
 * @method self alwaysOk()
 * @method self boolean(string $message = null)
 * @method self check(callable $fn, string $message = null)
 * @method self dateTimeFormat(string $format, string $message = null)
 * @method self email(string $message = null)
 * @method self fullName(string $message = null)
 * @method self inList(array $list, boolean $strict = true, string $message = null)
 * @method self isString(string $message = null)
 * @method self notEmpty(string $message = null)
 * @method self notNull(string $message = null)
 * @method self notRequired()
 * @method self pregMatch(string $pattern, string $message = null)
 * @method self uuid()
 */
class RuleSet implements Constraint, IteratorAggregate, Countable
{
    /** @var Constraint[] */
    private array $rules;

    final public function __construct(Constraint ...$rule)
    {
        $this->rules = $rule;
    }

    public static function new(): self
    {
        return new self();
    }

    public function add(Constraint ...$rules): self
    {
        array_push($this->rules, ...$rules);
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

    public function validateOrFail($data, array $context = [], string $field = '_errors', string $message = null): void
    {
        $this->validate($data, $context)->guard($field, $message);
    }

    public function __call(string $name, array $arguments): self
    {
        $class = sprintf("%s\%s", __NAMESPACE__ . '\\Constraints', ucfirst($name));
        if (!class_exists($class)) {
            throw new RuntimeException(sprintf('Constraint not found: (%s).', $name));
        }

        $this->rules[] = new $class(...$arguments);
        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->rules);
    }

    /** @return RuleSet[] */
    public static function fromClass(string|object $objectOrClass): array
    {
        $ruleSets = [];
        foreach((new ReflectionClass($objectOrClass))->getProperties() as $property) {
            $ruleSets[$property->getName()] = RuleSet::fromReflectionProperty($property);
        }

        return array_filter($ruleSets, fn(RuleSet $c) => !$c->isEmpty());
    }

    public static function fromProperty(string|object $objectOrClass, string $property): self
    {
        return self::fromReflectionProperty(new ReflectionProperty($objectOrClass, $property));
    }

    public static function fromReflectionProperty(ReflectionProperty $property): self
    {
        return new self(
            ...array_map(
                fn(ReflectionAttribute $attribute) => $attribute->newInstance(),
                $property->getAttributes(Constraint::class, ReflectionAttribute::IS_INSTANCEOF)
            )
        );
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->rules);
    }

    public function count(): int
    {
        return count($this->rules);
    }
}
