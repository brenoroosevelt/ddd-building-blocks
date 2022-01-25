<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support;

use BrenoRoosevelt\Specification\Spec\Rule;
use BrenoRoosevelt\Specification\Specification;
use Exception;
use Throwable;

final class Assert
{
    public static function that($value, Specification|callable|bool $rule, string|Throwable $error): void
    {
        if (!(new Rule($rule))->isSatisfiedBy($value)) {
            throw $error instanceof Throwable ? $error : new Exception($error);
        }
    }
}
