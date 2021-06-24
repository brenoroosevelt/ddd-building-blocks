<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DddBuildingBlocks\Application;

class Payload implements DataTransferObject
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

    public function has($name)
    {
        return array_key_exists($name, $this->data);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
