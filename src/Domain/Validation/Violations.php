<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class Violations implements IteratorAggregate, Countable
{
    /** @var string[] */
    private array $errors;

    final public function __construct(string ...$errors)
    {
        $this->errors = $errors;
    }

    public static function ok(): self
    {
        return new self();
    }

    public static function error(string ...$errors): self
    {
        return new self(...$errors);
    }

    public function add(string ...$error): self
    {
        array_push($this->errors, ...$error);
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isOk(): bool
    {
        return empty($this->errors);
    }

    public function guard(string $field = '_errors', $message = null): void
    {
        if (!$this->isOk()) {
            throw new ValidationErrors([$field => $this], $message);
        }
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->errors);
    }

    public function count(): int
    {
        return count($this->errors);
    }
}
