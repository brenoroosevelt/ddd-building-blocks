<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Infrastructure\Http;

use DateTimeImmutable;
use Psr\Http\Message\ServerRequestInterface;

class Input
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

    public function get($key, $default = null)
    {
        return $this->query[$key] ?? $this->body[$key] ?? $this->attributes[$key] ?? $default;
    }

    public function getString($key, ?string $default = null): ?string
    {
        $value = $this->get($key);
        return $value !== null ? (string) $value: $default;
    }

    public function getInt($key, ?int $default = null): ?int
    {
        $value = $this->get($key);
        return $value !== null ? (int) $value: $default;
    }

    public function getFloat($key, ?float $default = null): ?float
    {
        $value = $this->get($key);
        return $value !== null ? (float) $value: $default;
    }

    public function getBoolean($key, ?bool $default = null): ?bool
    {
        $value = $this->get($key);
        return $value !== null ? (bool) $value: $default;
    }

    public function getDateTime($key, ?string $default = null): ?DateTimeImmutable
    {
        $value = $this->get($key);
        $defaultValue = $default !== null ? new DateTimeImmutable($default) : null;
        return $value !== null ? new DateTimeImmutable($value) : $defaultValue;
    }
}
