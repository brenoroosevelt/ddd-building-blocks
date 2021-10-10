<?php
declare(strict_types=1);

namespace BrenoRoosevelt\DDD\BuildingBlocks\Application;

use BrenoRoosevelt\DDD\BuildingBlocks\Domain\AggregateRoot;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Identifiable;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\Repository;
use BrenoRoosevelt\DDD\BuildingBlocks\Domain\UseRepository;
use OniBus\Chain;
use OniBus\ChainTrait;
use OniBus\Handler\ClassMethod\ClassMethod;
use OniBus\Message;
use OniBus\NamedMessage;
use Psr\Container\ContainerInterface;
use ReflectionAttribute;
use ReflectionMethod;
use ReflectionNamedType;
use RuntimeException;

class Dispatcher implements Chain
{
    use ChainTrait;

    /** @var ClassMethod[] */
    private array $handlers;

    public function __construct(
        private ContainerInterface $container,
        ClassMethod ...$handlers,
    ) {
        $this->handlers = $handlers;
    }

    public function dispatch(Message $message)
    {
        $result = null;
        $messageName = $message instanceof NamedMessage ? $message->getMessageName() : get_class($message);
        $handlers = array_filter($this->handlers, fn(ClassMethod $cm) => $cm->message() === $messageName);
        if (empty($handlers)) {
            throw new RuntimeException(sprintf('No handler not found for message `%s`', $messageName));
        }

        foreach ($handlers as $classMethod) {
            $reflectionMethod = new ReflectionMethod($classMethod->class(), $classMethod->method());
            $repository = $this->repository($reflectionMethod);
            if ($repository instanceof Repository) {
                $result = $this->processAggregateRoot($repository, $message, $reflectionMethod);
            } else {
                $instance = $this->container->get($classMethod->class());
                $result = $this->invoke($reflectionMethod, $message, $instance);
            }
        }

        return $result;
    }

    private function processAggregateRoot(
        Repository $repository,
        Message $message,
        ReflectionMethod $reflectionMethod
    ) {
        if ($reflectionMethod->isStatic()) {
            $instance = $this->invoke($reflectionMethod, $message, null);
        } elseif ($message instanceof Identifiable) {
            $instance = $repository->ofId($message->getId());
            $this->invoke($reflectionMethod, $message, $instance);
        } else {
            throw new RuntimeException('Unprocessable aggregate');
        }

        if ($instance instanceof AggregateRoot) {
            $repository->save($instance);
        }

        return $instance;
    }

    private function invoke(ReflectionMethod $reflectionMethod, $message, $instance)
    {
        $args = $this->arguments($reflectionMethod, $message);
        return $reflectionMethod->invokeArgs($instance, $args);
    }

    private function repository(ReflectionMethod $reflectionMethod): ?Repository
    {
        $class = $reflectionMethod->getDeclaringClass();
        if (!is_subclass_of($class->getName(), AggregateRoot::class, true)) {
            return null;
        }

        $attribute = $class->getAttributes(UseRepository::class)[0] ?? null;
        $repositoryClass = $attribute instanceof ReflectionAttribute ? $attribute->newInstance()->repository : null;

        return
            $repositoryClass !== null && $this->container->has($repositoryClass) ?
                $this->container->get($repositoryClass) :
                null;
    }

    private function arguments(ReflectionMethod $method, Message $message): array
    {
        $args = [];
        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();
            if ($parameter->isDefaultValueAvailable()) {
                $args[$name] = $parameter->getDefaultValue();
            } elseif (!$parameter->isOptional() && $parameter->allowsNull()) {
                $args[$name] = null;
            } elseif ($parameter->isOptional()) {
                continue;
            } elseif ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $typeHint = ltrim($type->getName(), '?');
                if ($typeHint === 'self') {
                    $typeHint = $parameter->getDeclaringClass()->getName();
                }

                $args[$name] = $typeHint === get_class($message) ? $message : $this->container->get($typeHint);
            }
        }

        return $args;
    }
}
