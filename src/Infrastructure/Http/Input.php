<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http;

use ArrayAccess;
use ArrayIterator;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\ObjectParameter;
use Countable;
use DateTimeImmutable;
use IteratorAggregate;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

class Input implements ArrayAccess, IteratorAggregate, Countable, ObjectParameter
{
    public array $query;
    public array $body;
    public array $attributes;

    public function __construct(private ServerRequestInterface $request)
    {
        $this->query = $this->request->getQueryParams();
        $this->body = (array) $this->request->getParsedBody();
        $this->attributes = $this->request->getAttributes();
    }

    public function get(string $key, $default = null): mixed
    {
        return $this->query[$key] ?? $this->body[$key] ?? $this->attributes[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->query)
            || array_key_exists($key, $this->body)
            || array_key_exists($key, $this->attributes);
    }

    public function getString(string $key, ?string $default = null): ?string
    {
        return $this->has($key) ? (string) $this->get($key) : $default;
    }

    public function getInt(string $key, ?int $default = null): ?int
    {
        return $this->has($key) ? (int) $this->get($key) : $default;
    }

    public function getFloat(string $key, ?float $default = null): ?float
    {
        return $this->has($key) ? (float) $this->get($key) : $default;
    }

    public function getBoolean(string $key, ?bool $default = null): ?bool
    {
        return $this->has($key) ? (bool) $this->get($key) : $default;
    }

    public function getDateTime(string $key, ?string $default = null): ?DateTimeImmutable
    {
        $defaultValue = $default !== null ? new DateTimeImmutable($default) : null;
        return $this->has($key) ? new DateTimeImmutable($this->get($key)) : $defaultValue;
    }

    public function toArray(): array
    {
        return array_merge($this->attributes, $this->body, $this->query);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset)
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value)
    {
        throw new RuntimeException('Class `Input` is read-only: cannot set values');
    }

    public function offsetUnset(mixed $offset)
    {
        throw new RuntimeException('Class `Input` is read-only: cannot unset values');
    }

    public function count(): int
    {
        return count($this->toArray());
    }
}
