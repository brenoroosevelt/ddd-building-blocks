<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Application;

use JsonSerializable;

class Payload implements DataTransferObject, JsonSerializable
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __call($name, $arguments)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function has($name): bool
    {
        return array_key_exists($name, $this->data);
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
