<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractConstraint;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PregMatch extends AbstractConstraint
{
    public function __construct(private string $pattern, ?string $message = null)
    {
        parent::__construct($message ?? sprintf('Este valor não corresponde ao padrão: %s', $this->pattern));
    }

    public function isValid($input, array $context = []): bool
    {
        return preg_match($this->pattern, $input) === 1;
    }
}
