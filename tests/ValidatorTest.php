<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Email;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\InList;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\NotRequired;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationErrors;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $class = new class {
            #[InList(list: ['a', 'b'], message: 'Esolha A ou B')]
            private string $p1;
        };

        try {
            Validator::new()
                ->field('nome', new NotRequired, new Email);

        }catch (ValidationErrors $validationErrors) {
            var_dump($validationErrors->getMessage());
        }
    }
}
