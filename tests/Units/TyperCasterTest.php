<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use stdClass;
use TaylorNetwork\LaravelSettings\Contracts\DynamicallyCastsTypes;
use TaylorNetwork\LaravelSettings\DynamicTypeCaster;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Models\Setting;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class TyperCasterTest extends TestCase
{
    protected function model(array $attributes = []): DynamicallyCastsTypes
    {
        return new Setting($attributes);
    }

    protected function cast(string $value, DataType $dataType): mixed
    {
        $attributes = [
            'value' => $value,
            'data_type' => $dataType,
        ];

        return (new DynamicTypeCaster)->get($this->model($attributes), 'value', $value, $attributes);
    }

    /** @test */
    public function it_can_cast_to_array()
    {
        $array = $this->cast('{"key":"array.key.one","value":"some test value"}', DataType::ARRAY);

        $this->assertIsArray($array);
        $this->assertEquals([
            'key' => 'array.key.one',
            'value' => 'some test value',
        ], $array);
    }

    /** @test */
    public function it_can_cast_to_bool()
    {
        $true = $this->cast('true', DataType::BOOL);
        $false = $this->cast('0', DataType::BOOLEAN);

        $this->assertIsBool($true);
        $this->assertTrue($true);
        $this->assertIsBool($false);
        $this->assertFalse($false);
    }

    /** @test */
    public function it_can_cast_to_collection()
    {
        $collection = $this->cast('[{"key":"col.one","value":"collection 1"},{"key":"col.two","value":"collection 2"}]', DataType::COLLECTION);

        $this->assertIsObject($collection);
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertEquals(2, $collection->count());
        $this->assertEquals([
            'key' => 'col.one',
            'value' => 'collection 1'
        ], $collection->first());
        $this->assertEquals('collection 2', $collection->where('key', 'col.two')->first()['value']);
    }

    /** @test */
    public function it_can_cast_to_date()
    {
        $date = $this->cast('Jan 1, 2022', DataType::DATE);

        $this->assertInstanceOf(Carbon::class, $date);
        $this->assertEquals('2022-01-01 00:00:00', $date);
    }

    /** @test */
    public function it_can_cast_to_datetime()
    {
        $datetime = $this->cast('Jan 1, 2022 5:00 PM', DataType::DATETIME);

        $this->assertInstanceOf(Carbon::class, $datetime);
        $this->assertEquals('2022-01-01 17:00:00', $datetime);
    }

    /** @test */
    public function it_can_cast_to_float()
    {
        $double = $this->cast('1.5', DataType::DOUBLE);
        $float = $this->cast('2.5', DataType::FLOAT);
        $real = $this->cast('3.5', DataType::REAL);

        $this->assertIsFloat($double);
        $this->assertEquals(1.5, $double);
        $this->assertIsFloat($float);
        $this->assertEquals(2.5, $float);
        $this->assertIsFloat($real);
        $this->assertEquals(3.5, $real);
    }

    /** @test */
    public function it_can_cast_to_int()
    {
        $int = $this->cast('10', DataType::INT);
        $integer = $this->cast('15', DataType::INTEGER);

        $this->assertIsInt($int);
        $this->assertEquals(10, $int);
        $this->assertIsInt($integer);
        $this->assertEquals(15, $integer);
    }

    /** @test */
    public function it_can_cast_to_json()
    {
        $json = $this->cast('{"key":"json.one","value":"a value"}', DataType::JSON);

        $this->assertIsArray($json);
        $this->assertEquals([
            'key' => 'json.one',
            'value' => 'a value',
        ], $json);
    }

    /** @test */
    public function it_can_cast_to_object()
    {
        $object = $this->cast('{"key":"objKey","value":"obj value"}', DataType::OBJECT);

        $this->assertIsObject($object);
        $this->assertInstanceOf(stdClass::class, $object);
        $this->assertEquals('objKey', $object->key);
        $this->assertEquals('obj value', $object->value);
    }

    /** @test */
    public function it_can_cast_to_string()
    {
        $string = $this->cast('string 1', DataType::STRING);

        $this->assertIsString($string);
        $this->assertEquals('string 1', $string);
    }

    /** @test */
    public function it_can_cast_to_timestamp()
    {
        $timestamp = $this->cast('Jan 1, 2022', DataType::TIMESTAMP);

        $this->assertIsInt($timestamp);
        $this->assertEquals(1640995200, $timestamp);
    }
}
