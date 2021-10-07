<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Exception\ValidationErrors;

class ValidationResult implements ValidationResultInterface
{
    const EMPTY_FIELD = '_errors';

    private array $errors = [];

    public static function empty(): self
    {
        return new self();
    }

    public static function ok(): self
    {
        return new self();
    }

    public static function problem(string $message, ?string $field = null): self
    {
        return (new self())->error($message, $field);
    }

    public function error(string $message, ?string $field = null): self
    {
        $this->errors[$field ?? self::EMPTY_FIELD][] = $message;
        return $this;
    }

    public function errorField(string $field, string ...$errors): self
    {
        foreach ($errors as $error) {
            $this->error($error, $field);
        }

        return $this;
    }

    public function field(string $field): self
    {
        $instance = self::empty();
        if (isset($this->errors[$field])) {
            $instance->errors[$field] = $this->errors[$field];
        }

        return $instance;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function messages(): array
    {
        $messages = [];
        foreach ($this->errors as $field => $errors) {
            array_push($messages, ...$errors);
        }

        return $messages;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function isOk(): bool
    {
        return empty($this->errors);
    }

    public function guard(): void
    {
        if ($this->hasErrors()) {
            throw new ValidationErrors($this->getErrors());
        }
    }
}
