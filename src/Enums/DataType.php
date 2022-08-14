<?php

namespace TaylorNetwork\LaravelSettings\Enums;

use Illuminate\Support\Str;
use TaylorNetwork\LaravelSettings\Contracts\ProvidesArrayOfValues;
use TaylorNetwork\LaravelSettings\Traits\SharesEnumValues;

enum DataType: string implements ProvidesArrayOfValues
{
    use SharesEnumValues;

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

    public static function primitives(): array
    {
        return [
            self::ARRAY,
            self::BOOL,
            self::BOOLEAN,
            self::DOUBLE,
            self::FLOAT,
            self::INT,
            self::INTEGER,
            self::OBJECT,
            self::REAL,
            self::STRING,
        ];
    }

    public static function strings(): array
    {
        return [
            self::STRING,
            self::JSON,
        ];
    }

    public static function ints(): array
    {
        return self::integers();
    }

    public static function integers(): array
    {
        return [
            self::INT,
            self::INTEGER,
        ];
    }

    public static function floats(): array
    {
        return [
            self::FLOAT,
            self::DOUBLE,
            self::REAL,
        ];
    }

    public static function booleans(): array
    {
        return [
            self::BOOL,
            self::BOOLEAN,
        ];
    }

    public static function bools(): array
    {
        return self::booleans();
    }

    public static function objects(): array
    {
        return [
            self::OBJECT,
            self::DATE,
            self::DATETIME,
            self::COLLECTION,
        ];
    }

    public function isPrimitive(): bool
    {
        return $this->is('primitive');
    }

    public function is(self|string|null $type): bool
    {
        $dataType = $type instanceof self ? $type : self::tryFrom($type);

        if($dataType) {
            return $this === $dataType;
        }

        if(method_exists($this, $method = Str::camel(Str::plural($type)))) {
            return in_array($this, self::$method());
        }

        return false;
    }

    public function isIn(array $types): bool
    {
        foreach($types as $type) {
            if($this->is($type)) {
                return true;
            }
        }
        return false;
    }

    public function convertValueToString(mixed $value): string
    {
        if($this->is(self::ARRAY)) {
            return json_encode($value);
        }

        return (string) $value;
    }
 }
