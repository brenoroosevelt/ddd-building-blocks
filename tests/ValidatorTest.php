<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Test;

use BrenoRoosevelt\DDD\BuildingBlocks\Application\Middleware\Bus;
use BrenoRoosevelt\DDD\BuildingBlocks\Application\Middleware\DirectMapping;
use BrenoRoosevelt\DDD\BuildingBlocks\Application\Middleware\MiddlewareStack;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\IntCollection;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection2;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\CollectionTrait;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Support\Collection\Collection;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\Email;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Constraints\InList;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\NotRequired;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\ValidationErrors;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Validator;
use BrenoRoosevelt\DDD\BuildingBlocks\Test\Fixture\Subject1;
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

    public function testAny()
    {
        $m = new DirectMapping();
        $m->map(Subject1::class, fn(Subject1 $s) => var_dump($s->value));

        $bus = new Bus([$m]);
        $bus->handle(new Subject1('ui'));

//        MiddlewareStack::dispatch(new Subject1('ui'),
//            function($subject, callable $next) {
//                $next($subject);
//                var_dump($subject);
//            },
//            $m);
    }
}
