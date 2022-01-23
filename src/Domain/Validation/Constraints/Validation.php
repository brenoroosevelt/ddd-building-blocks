<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractRule;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Violations;
use UnexpectedValueException;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class Validation extends AbstractRule
{
    private Rule $constraint;

    public function __construct($constraint, private ?string $message = null, private bool $stopOnFailure = false)
    {
        $this->constraint = $this->parseConstraint($constraint, $message);
    }

    private function parseConstraint($constraint, $message): Rule
    {
        if ($constraint instanceof Rule) {
            return $constraint;
        }

        if (is_callable($constraint)) {
            return $this->callableConstraint($constraint, $message);
        }

        $args = [];
        $constraintClass = $constraint;

        if (is_array($constraint)) {
            $args = $constraint;
            $constraintClass = array_shift($args);
        }

        if (is_string($constraintClass) && is_subclass_of($constraintClass, Rule::class, true)) {
            return new $constraintClass(...$args);
        }

        throw new UnexpectedValueException('Invalid constraint: ' . (string) $constraintClass);
    }

    public function constraint(): Rule
    {
        return $this->constraint;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    public function validate($input, array $context = []): Violations
    {
        $result = $this->constraint->validate($input, $context);
        if (!$result->hasErrors()) {
            return $result;
        }

        return !empty($this->message) ? Violations::error($this->message) : $result;
    }

    public function stopOnFailure(): bool
    {
        return $this->stopOnFailure;
    }

    private function callableConstraint(callable $fn, $message): Rule
    {
        return new class($fn, $message) implements Rule {
            public function __construct(private $fn, private $message)
            {
            }

            public function validate($input, array $context = []): Violations
            {
                return
                    true === (bool) ($this->fn)($input, $context) ?
                        Violations::ok() :
                        Violations::error($this->message ?? 'invalid input');
            }
        };
    }
}
