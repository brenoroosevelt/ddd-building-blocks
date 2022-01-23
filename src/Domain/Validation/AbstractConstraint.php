<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

abstract class AbstractConstraint implements Constraint
{
    protected string $message;

    public function __construct(string $message = null)
    {
        $this->message = $message ?? sprintf('Constraint violation: %s', get_class($this));
    }

    public function validate($input, array $context = []): Violations
    {
        return $this->isValid($input, $context) ? Violations::ok() : Violations::error($this->message);
    }

    protected abstract function isValid($input, array $context = []): bool;
}
