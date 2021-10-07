<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationResult;
use DateTime;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeFormat implements Constraint
{
    public function __construct(private string $format)
    {
    }

    public function validate($input, array $context = []): ValidationResult
    {
        if (!is_string($input)) {
            return $this->error();
        }

        $d = DateTime::createFromFormat($this->format, $input);
        return $d && $d->format($this->format) === $input ?
            ValidationResult::ok() :
            $this->error();
    }

    private function error(): ValidationResult
    {
        return ValidationResult::problem(sprintf('Formato inválido, use %s', $this->format));
    }
}
