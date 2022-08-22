<?php

namespace Envorra\LaravelSettings\Tests\Environment\SharedTests;

use ReflectionClass;
use ReflectionProperty;
use ReflectionException;

trait ReflectionTests
{
    protected function defaultClassToReflect(): string|object|null
    {
        return null;
    }

    /**
     * @throws ReflectionException
     */
    protected function reflect(string|object|null $class = null): ReflectionClass
    {
        $class ??= $this->defaultClassToReflect();

        return new ReflectionClass($class);
    }

    /**
     * @throws ReflectionException
     */
    protected function reflectProp(string $property): ReflectionProperty
    {
        return $this->reflect()->getProperty($property);
    }

    /**
     * @throws ReflectionException
     */
    protected function reflectPropValue(string $property, object $targetObject): mixed
    {
        return $this->reflectProp($property)->getValue($targetObject);
    }
}
