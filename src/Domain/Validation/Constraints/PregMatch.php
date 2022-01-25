<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Rule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PregMatch extends Rule
{
    public function __construct(private string $pattern, ?string $message = null)
    {
        parent::__construct(
            new \BrenoRoosevelt\Specification\Spec\PregMatch($this->pattern),
            $message ?? sprintf('Este valor não corresponde ao padrão: %s', $this->pattern)
        );
    }
}
