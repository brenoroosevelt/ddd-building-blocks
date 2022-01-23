<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraint;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Violations;
use DateTime;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DateTimeFormat implements Constraint
{
    const MESSAGE = 'Formato de data e/ou hora inválido, use %s';
    private string $message;

    public function __construct(private string $format, string $message = null)
    {
        $this->message = $message ?? sprintf(self::MESSAGE, $this->format);
    }

    public function validate($input, array $context = []): Violations
    {
        $isStringViolation = (new IsString())->validate($input, $context);
        if (!$isStringViolation->isOk()) {
            return $isStringViolation;
        }

        $d = DateTime::createFromFormat($this->format, $input);
        return $d && $d->format($this->format) === $input ?
            Violations::ok() :
            Violations::error($this->message);
    }
}
