<?php

namespace Envorra\LaravelSettings\Enums;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Envorra\LaravelSettings\Exceptions\DataTypeException;
use Envorra\LaravelSettings\Contracts\ProvidesArrayOfValues;

/**
 * DataType
 *
 * @package Envorra\LaravelSettings
 */
enum DataType: string implements ProvidesArrayOfValues
{
    case ARRAY = 'array';
    case BOOL = 'bool';
    case BOOLEAN = 'boolean';
    case COLLECTION = 'collection';
    case DATE = 'date';
    case DATETIME = 'datetime';
//    case DECIMAL = 'decimal';
    case DOUBLE = 'double';
    case FLOAT = 'float';
    case INT = 'int';
    case INTEGER = 'integer';
    case JSON = 'json';
    case OBJECT = 'object';
    case REAL = 'real';
    case STRING = 'string';
    case TIMESTAMP = 'timestamp';

    /**
     * Map of data types and their aliases.
     *
     * @return array<array<DataType>>
     */
    public static function aliasMap(): array
    {
        return [
            [self::INTEGER, self::INT],
            [self::BOOLEAN, self::BOOL],
            [self::FLOAT, self::REAL, self::DOUBLE],
        ];
    }

    /**
     * Are all given data types the same primitive type?
     *
     * @param  DataType         $primitiveDataType
     * @param  array<DataType>  $typesToCheck
     * @return bool
     * @throws DataTypeException
     */
    public static function areAllOfPrimitiveType(DataType $primitiveDataType, array $typesToCheck): bool
    {
        if (!$primitiveDataType->isPrimitive()) {
            throw new DataTypeException('$primitiveDataType should be a primitive data type.');
        }

        foreach ($typesToCheck as $type) {
            if (!$type->toPrimitive()->is($primitiveDataType)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Are all given data types the same type?
     *
     * @param  DataType         $dataType
     * @param  array<DataType>  $typesToCheck
     * @return bool
     */
    public static function areAllOfType(DataType $dataType, array $typesToCheck): bool
    {
        foreach ($typesToCheck as $type) {
            if (!$type->is($dataType)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Map of classes to their data types.
     *
     * @return array<class-string, array<DataType>>
     */
    public static function classMap(): array
    {
        return [
            Collection::class => [
                self::COLLECTION,
            ],
            Carbon::class => [
                self::DATETIME,
                self::DATE,
            ],
        ];
    }

    /**
     * New instance from the type of variable passed.
     *
     * @param  mixed  $value
     * @return static
     */
    public static function fromValue(mixed $value): self
    {
        $primitive = self::from(gettype($value));

        if ($primitive->is(self::OBJECT)) {
            $valueClass = get_class($value);
            if (array_key_exists($valueClass, self::classMap())) {
                return Arr::first(self::classMap()[$valueClass]);
            }
        }

        return $primitive;
    }

    /**
     * Is a given integer a valid timestamp?
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function integerIsValidTimestamp(mixed $value): bool
    {
        if (self::fromValue($value)->is(self::INTEGER)) {
            return $value === strtotime(date('c', $value));
        }
        return false;
    }

    /**
     * Map of data types to their primitive counterparts.
     *
     * @return array<string, array<DataType>>
     */
    public static function primitiveMap(): array
    {
        return [
            'string' => [
                self::STRING,
                self::JSON,
            ],
            'integer' => [
                self::INTEGER,
                self::INT,
                self::TIMESTAMP,
            ],
            'boolean' => [
                self::BOOLEAN,
                self::BOOL,
            ],
            'double' => [
                self::DOUBLE,
                self::FLOAT,
                self::REAL,
            ],
            'array' => [
                self::ARRAY,
            ],
            'object' => [
                self::OBJECT,
                self::COLLECTION,
                self::DATE,
                self::DATETIME,
            ],
        ];
    }

    /**
     * PHP primitive data types.
     *
     * @return array<DataType>
     */
    public static function primitives(): array
    {
        return [
            self::ARRAY,
            self::BOOLEAN,
            self::DOUBLE,
            self::INTEGER,
            self::OBJECT,
            self::STRING,
        ];
    }

    /**
     * Is a given string valid JSON?
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function stringIsValidJson(mixed $value): bool
    {
        if (self::fromValue($value)->is(self::STRING)) {
            json_decode($value);
            return json_last_error() === JSON_ERROR_NONE;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }

    /**
     * The data type's aliases.
     *
     * @return array<DataType>
     */
    public function aliases(): array
    {
        foreach (self::aliasMap() as $aliases) {
            if (in_array($this, $aliases)) {
                return $aliases;
            }
        }
        return [];
    }

    /**
     * Convert the inbound value to its string representation.
     *
     * @param  mixed  $value
     * @return string
     */
    public function convertValueToString(mixed $value): string
    {
        if ($this->is(self::ARRAY)) {
            return json_encode($value);
        }

        return (string) $value;
    }

    /**
     * Checks if the given type is the same as this one.
     *
     * @param  DataType|string|null  $type
     * @return bool
     */
    public function is(self|string|null $type): bool
    {
        $dataType = $type instanceof self ? $type : self::tryFrom($type);

        if ($dataType) {
            if ($this === $dataType) {
                return true;
            }

            return in_array($dataType, $this->aliases());
        }

        return false;
    }

    /**
     * Check if this data type is any of the given ones.
     *
     * @param  array<DataType>|array<string>  $types
     * @return bool
     */
    public function isIn(array $types): bool
    {
        foreach ($types as $type) {
            if ($this->is($type)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Is this type a primitive type?
     *
     * @return bool
     */
    public function isPrimitive(): bool
    {
        return in_array($this, self::primitives());
    }

    /**
     * Resolve the class from the data type.
     *
     * @return ?string
     */
    public function resolveObjectClass(): ?string
    {
        if ($this->toPrimitive()->is(self::OBJECT)) {
            foreach (self::classMap() as $class => $types) {
                if (in_array($this, Arr::wrap($types))) {
                    return $class;
                }
            }
        }
        return null;
    }

    /**
     * Convert this data type to its primitive version.
     *
     * @return ?static
     */
    public function toPrimitive(): ?self
    {
        if ($this->isPrimitive()) {
            return $this;
        }

        foreach (self::primitiveMap() as $primitive => $types) {
            if (in_array($this, Arr::wrap($types))) {
                return self::from($primitive);
            }
        }

        return null;
    }

    /**
     * Is the given value the same type as this instance?
     *
     * @param  mixed  $value
     * @return bool
     */
    public function valueIsType(mixed $value): bool
    {
        $type = self::fromValue($value);

        if ($this->isPrimitive() && $type->isPrimitive()) {
            return $this->is($type);
        }

        if ($this->toPrimitive()->isIn([self::OBJECT, self::STRING, self::INTEGER])) {
            if ($this->is(self::TIMESTAMP) && $type->is(self::INTEGER)) {
                return self::integerIsValidTimestamp($value);
            }

            if ($this->is(self::JSON) && $type->is(self::STRING)) {
                return self::stringIsValidJson($value);
            }

            try {
                if (self::areAllOfPrimitiveType(DataType::OBJECT, [$this, $type])) {
                    $class = $this->resolveObjectClass();
                    return $class && $value instanceof $class;
                }
            } catch (DataTypeException) {
            }

        }

        return $this->toPrimitive()->is($type);
    }
}
