<?php

namespace Envorra\LaravelSettings\Casters;

use Stringable;
use Envorra\TypeHandler\Contracts\Types\Type;
use Envorra\LaravelSettings\Contracts\Caster;
use Envorra\TypeHandler\Factories\TypeFactory;
use Envorra\TypeHandler\Exceptions\TypeFactoryException;
use Envorra\LaravelSettings\Contracts\HasDataType;

/**
 * ValueCaster
 *
 * @package Envorra\LaravelSettings\Casters
 */
class ValueCaster implements Caster
{
    /**
     * @inheritDoc
     * @throws TypeFactoryException
     */
    public function get($model, string $key, mixed $value, array $attributes): mixed
    {
        if($model instanceof HasDataType) {
            return $this->getDataTypeFromModel($model, $value)->getValue();
        }

        return $this->typeFromValue($value)->getValue();
    }

    /**
     * @inheritDoc
     * @throws TypeFactoryException
     */
    public function set($model, string $key, mixed $value, array $attributes): string
    {
        if(is_string($value)) {
            return $value;
        }

        if($value instanceof Stringable) {
            return (string) $value;
        }

        if($model instanceof HasDataType) {
            return (string) $this->getDataTypeFromModel($model, $value);
        }

        return (string) $this->typeFromValue($value);
    }

    /**
     * @param  HasDataType  $model
     * @param  mixed        $value
     * @return Type
     */
    protected function getDataTypeFromModel(HasDataType $model, mixed $value): Type
    {
        return $model->getDataType()::make($value);
    }

    /**
     * @param  mixed  $value
     * @return Type
     * @throws TypeFactoryException
     */
    protected function typeFromValue(mixed $value): Type
    {
        return TypeFactory::createFromValue($value ?? '');
    }
}
