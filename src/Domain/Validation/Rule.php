<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation;

use Attribute;
use BrenoRoosevelt\Specification\Specification;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Rule extends AbstractConstraint
{
    private Specification $specification;

    public function __construct(
        $rule,
        string $message = null
    ) {
        parent::__construct($message);
        $this->specification = new \BrenoRoosevelt\Specification\Spec\Rule($rule);
    }

    protected function isValid($input, array $context = []): bool
    {
        return $this->specification->isSatisfiedBy($input);
    }
}
