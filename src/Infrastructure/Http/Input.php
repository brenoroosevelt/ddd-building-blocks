<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http;

use ArrayAccess;
use ArrayIterator;
use DateTimeImmutable;
use IteratorAggregate;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

class Input implements ArrayAccess, IteratorAggregate
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

    public function get(string $key, $default = null)
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
        $value = $this->get($key);
        return $value !== null ? (string) $value: $default;
    }

    public function getInt(string $key, ?int $default = null): ?int
    {
        $value = $this->get($key);
        return $value !== null ? (int) $value: $default;
    }

    public function getFloat(string $key, ?float $default = null): ?float
    {
        $value = $this->get($key);
        return $value !== null ? (float) $value: $default;
    }

    public function getBoolean(string $key, ?bool $default = null): ?bool
    {
        $value = $this->get($key);
        return $value !== null ? (bool) $value: $default;
    }

    public function getDateTime(string $key, ?string $default = null): ?DateTimeImmutable
    {
        $value = $this->get($key);
        $defaultValue = $default !== null ? new DateTimeImmutable($default) : null;
        return $value !== null ? new DateTimeImmutable($value) : $defaultValue;
    }

    public function all(): array
    {
        return array_merge($this->attributes, $this->body, $this->query);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->all());
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
        throw new RuntimeException('Read only input: cannot set values');
    }

    public function offsetUnset(mixed $offset)
    {
        throw new RuntimeException('Read only input: cannot unset values');
    }
}
