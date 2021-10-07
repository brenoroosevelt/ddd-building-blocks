<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Domain;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Validation\Validator;
use ReflectionAttribute;
use ReflectionClass;

class DataTransferObject
{
    public function __construct(...$args)
    {
        if (is_array($args[0] ?? null)) {
            $args = $args[0];
        }

        $this->getValidator()->validate($args);
        //$this->castValues($args);
        //$this->getPostValidator()->validate($args);
        foreach ($args as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }
    }

    protected function getValidator(): Validator
    {
        return Validator::fromAttributes($this);
    }

//    public function getPostValidator(): Validator
//    {
//        return Validator::fromAttributes($this, PostValidation::class);
//    }
//
//    private function castValues(array &$raw = []): void
//    {
//        foreach ((new ReflectionClass($this))->getProperties() as $property) {
//            $name = $property->getName();
//            if (!array_key_exists($name, $raw)) {
//                continue;
//            }
//
//            $attribute =
//                $property->getAttributes(Cast::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;
//            if ($attribute instanceof ReflectionAttribute) {
//                /** @var Cast $castWith */
//                $castWith = $attribute->newInstance();
//                $raw[$name] = $castWith->caster()->cast($raw[$name]);
//            }
//        }
//    }
}
