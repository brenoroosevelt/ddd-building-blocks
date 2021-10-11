<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;
use UnexpectedValueException;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class Validation extends AbstractConstraint
{
    private Constraint $constraint;

    public function __construct($constraint, private ?string $message = null, private bool $stopOnFailure = false)
    {
        $this->constraint = $this->parseConstraint($constraint, $message);
    }

    private function parseConstraint($constraint, $message): Constraint
    {
        if ($constraint instanceof Constraint) {
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

        if (is_string($constraintClass) && is_subclass_of($constraintClass, Constraint::class, true)) {
            return new $constraintClass(...$args);
        }

        throw new UnexpectedValueException('Invalid constraint: ' . (string) $constraintClass);
    }

    public function constraint(): Constraint
    {
        return $this->constraint;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    public function validate($input, array $context = []): ValidationResult
    {
        $result = $this->constraint->validate($input, $context);
        if (!$result->hasErrors()) {
            return $result;
        }

        return !empty($this->message) ? ValidationResult::problem($this->message) : $result;
    }

    public function stopOnFailure(): bool
    {
        return $this->stopOnFailure;
    }

    private function callableConstraint(callable $fn, $message): Constraint
    {
        return new class($fn, $message) implements Constraint {
            public function __construct(private $fn, private $message)
            {
            }

            public function validate($input, array $context = []): ValidationResult
            {
                return
                    true === (bool) ($this->fn)($input, $context) ?
                        ValidationResult::ok() :
                        ValidationResult::problem($this->message ?? 'invalid input');
            }
        };
    }
}
