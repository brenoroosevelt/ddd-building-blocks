<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractConstraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Check extends AbstractConstraint
{
    private $fn;

    public function __construct(callable $fn, ?string $message = 'Este valor é inválido')
    {
        parent::__construct($message);
        $this->fn = $fn;
    }

    public function isValid($input, array $context = []): bool
    {
        return call_user_func_array($this->fn, [$input, $context]) === true;
    }
}
