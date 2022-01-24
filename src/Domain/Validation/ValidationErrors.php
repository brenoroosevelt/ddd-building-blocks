<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use DomainException;
use Throwable;

class ValidationErrors extends DomainException
{
    /** @var Violations[]  */
    private array $errors;

    public function __construct(array $errors, $message = null, $code = 422, Throwable $previous = null)
    {
        $this->errors = array_filter($errors, fn($error) => $error instanceof Violations);
        $messages = [];
        foreach ($errors as $fieldName => $errorsForField) {
            foreach ($errorsForField as $errorForField) {
                $messages[] = "\t - `$fieldName`: $errorForField";
            }
        }

        $message = $message ?? "Validation errors:" . PHP_EOL . implode(PHP_EOL, $messages);
        parent::__construct($message, $code, $previous);
    }

    /** @return Violations[] */
    public function errors(): array
    {
        return $this->errors;
    }
}
