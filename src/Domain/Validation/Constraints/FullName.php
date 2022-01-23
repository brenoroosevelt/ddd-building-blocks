<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints;

use Attribute;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\AbstractRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FullName extends AbstractRule
{
    const MIN_LEN = 5;
    const MIN_WORDS = 2;

    public function __construct(string $message = 'Nome deve ser completo')
    {
        parent::__construct($message);
    }

    public function isValid($input, array $context = []): bool
    {
        return
            is_string($input) &&
            count(explode(' ', $input)) >= self::MIN_WORDS &&
            mb_strlen($input) >= self::MIN_LEN;
    }
}
