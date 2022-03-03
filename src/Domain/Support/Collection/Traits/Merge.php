<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Traits;

use InvalidArgumentException;

trait Merge
{
    use Data;

    public function merge(self $other): static
    {
        if (! $other instanceof $this) {
            throw new InvalidArgumentException(
                sprintf(
                    'Cannot merge collections: expected %s, got %s',
                    static::class,
                    get_class($other)
                )
            );
        }

        return $this->withData(...$this->data, ...$other->data);
    }
}
