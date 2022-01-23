<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class InList extends AbstractRule
{
    public function __construct(private array $list, ?string $message = null)
    {
        parent::__construct(
            $message ??
            sprintf('Valor inválido, os valores permitidos são: %s', implode(', ', $this->list))
        );
    }

    public function isValid($input, array $context = []): bool
    {
        return in_array($input, $this->list, true);
    }
}
