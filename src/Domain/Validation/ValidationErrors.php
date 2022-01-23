<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use DomainException;
use Throwable;

class ValidationErrors extends DomainException
{
    private array $errors;

    public function __construct(array $errors, $message = '', $code = 422, Throwable $previous = null)
    {
        $this->errors = $errors;
        $messages = [];
        foreach ($errors as $fieldName => $errorsForField) {
            foreach ($errorsForField as $errorForField) {
                $messages[] = "\t - `$fieldName`: $errorForField";
            }
        }

        $message = $message ?? "Validation errors:" . PHP_EOL . implode(PHP_EOL, $messages);
        parent::__construct($message, $code, $previous);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
