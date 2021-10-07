<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;

abstract class AbstractConstraint implements Constraint
{
    protected static string $defaultMessage = 'invalid input';

    public function validateOrFail($input, array $context = []): void
    {
        $this->validate($input, $context)->guard();
    }

    public static function defaultMessage(): string
    {
        return static::$defaultMessage;
    }

    public static function setDefaultMessage(string $defaultMessage): void
    {
        static::$defaultMessage = $defaultMessage;
    }

    protected function error(): ValidationResult
    {
        return ValidationResult::problem(static::defaultMessage());
    }

    protected function ok(): ValidationResult
    {
        return ValidationResult::ok();
    }
}
