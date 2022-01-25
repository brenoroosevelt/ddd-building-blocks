<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;
use BrenoRoosevelt\Specification\Spec\In;

#[Attribute(Attribute::TARGET_PROPERTY)]
class InList extends Rule
{
    public function __construct(private array $list, private bool $strict = true, string $message = null)
    {
        parent::__construct(
            new In($list, $this->strict),
            $message ??
            sprintf('Valor inválido, os valores permitidos são: %s', implode(', ', $this->list))
        );
    }
}
