<?php

namespace TaylorNetwork\LaravelSettings\Tests\Unit\Enums;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Exceptions\DataTypeException;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

/**
 * @coversDefaultClass \TaylorNetwork\LaravelSettings\Enums\DataType
 */
class DataTypeTest extends TestCase
{
    /**
     * @test
     * @covers ::aliasMap
     */
    public function it_returns_array_of_data_type_aliases(): void
    {
        $map = DataType::aliasMap();
        $this->assertIsArray($map);
        foreach($map as $types) {
            $this->assertIsArray($types);
            $this->assertAllInstanceOf(DataType::class, $types);
        }
    }

    /**
     * @test
     * @covers ::valueIsType
     */
    public function it_returns_if_given_value_is_data_type(): void
    {
        $this->assertTrue(DataType::INT->valueIsType(25));
        $this->assertTrue(DataType::STRING->valueIsType('test'));
        $this->assertTrue(DataType::JSON->valueIsType('{"key":"value"}'));
        $this->assertTrue(DataType::COLLECTION->valueIsType(collect()));
        $this->assertFalse(DataType::INTEGER->valueIsType('25'));
    }

    /**
     * @test
     * @covers ::stringIsValidJson
     */
    public function it_returns_if_given_string_is_valid_json(): void
    {
        $this->assertTrue(DataType::stringIsValidJson('{}'));
        $this->assertTrue(DataType::stringIsValidJson('["array","of","values"]'));
        $this->assertFalse(DataType::stringIsValidJson('test'));
    }

    /**
     * @test
     * @covers ::areAllOfType
     */
    public function it_returns_whether_all_data_types_are_the_same_in_given_array(): void
    {
        $this->assertTrue(DataType::areAllOfType(DataType::INT, [DataType::INTEGER, DataType::INT]));
        $this->assertTrue(DataType::areAllOfType(DataType::FLOAT, [DataType::DOUBLE, DataType::REAL]));
        $this->assertFalse(DataType::areAllOfType(DataType::OBJECT, [DataType::COLLECTION, DataType::DATE]));
    }

    /**
     * @test
     * @covers ::values
     */
    public function it_returns_an_array_of_enum_backing_values(): void
    {
        $this->checkEnumValuesMethod(DataType::class);
    }

    /**
     * @test
     * @covers ::resolveObjectClass
     */
    public function it_can_resolve_the_objects_class(): void
    {
        $this->assertEquals(Collection::class, DataType::COLLECTION->resolveObjectClass());
        $this->assertEquals(Carbon::class, DataType::DATE->resolveObjectClass());
        $this->assertEquals(Carbon::class, DataType::DATETIME->resolveObjectClass());
        $this->assertNull(DataType::TIMESTAMP->resolveObjectClass());
    }

    /**
     * @test
     * @covers ::isIn
     */
    public function it_returns_whether_data_type_is_in_an_array_of_types(): void
    {
        $this->checkEnumIsInMethod(DataType::class);
    }

    /**
     * @test
     * @covers ::integerIsValidTimestamp
     */
    public function it_returns_whether_an_integer_is_a_valid_timestamp(): void
    {
        $this->assertTrue(DataType::integerIsValidTimestamp(time()));
        $this->assertFalse(DataType::integerIsValidTimestamp(999999999999));
    }

    /**
     * @test
     * @covers ::fromValue
     */
    public function it_creates_a_new_instance_from_a_input_value(): void
    {
        $this->assertEquals(DataType::INTEGER, DataType::fromValue(25));
        $this->assertEquals(DataType::BOOLEAN, DataType::fromValue(true));
        $this->assertEquals(DataType::DOUBLE, DataType::fromValue(1.5));
        $this->assertEquals(DataType::COLLECTION, DataType::fromValue(collect()));
        $this->assertEquals(DataType::ARRAY, DataType::fromValue([]));
        $this->assertEquals(DataType::DATETIME, DataType::fromValue(Carbon::now()));
    }

    /**
     * @test
     * @covers ::areAllOfPrimitiveType
     */
    public function it_returns_whether_an_array_of_types_are_all_primitives(): void
    {
        $this->assertTrue(DataType::areAllOfPrimitiveType(DataType::INTEGER, [
            DataType::INT,
            DataType::TIMESTAMP,
        ]));

        $this->assertTrue(DataType::areAllOfPrimitiveType(DataType::OBJECT, [
            DataType::OBJECT,
            DataType::DATE,
            DataType::COLLECTION,
        ]));

        $this->assertFalse(DataType::areAllOfPrimitiveType(DataType::STRING, [
            DataType::JSON,
            DataType::STRING,
            DataType::INTEGER,
        ]));

        $this->expectException(DataTypeException::class);
        DataType::areAllOfPrimitiveType(DataType::COLLECTION, []);
    }

    /**
     * @test
     * @covers ::toPrimitive
     */
    public function it_converts_a_data_type_to_its_primitive_version(): void
    {
        $this->assertEquals(DataType::INTEGER, DataType::TIMESTAMP->toPrimitive());
        $this->assertEquals(DataType::STRING, DataType::JSON->toPrimitive());
        $this->assertEquals(DataType::OBJECT, DataType::COLLECTION->toPrimitive());
        $this->assertEquals(DataType::OBJECT, DataType::DATETIME->toPrimitive());
        $this->assertEquals(DataType::INTEGER, DataType::INT->toPrimitive());
    }

    /**
     * @test
     * @covers ::is
     */
    public function it_returns_whether_data_types_are_the_same(): void
    {
        $this->checkEnumIsMethod(DataType::class);
    }

    /**
     * @test
     * @covers ::classMap
     */
    public function it_returns_map_of_data_types_to_their_object_classes(): void
    {
        $this->assertIsArray(DataType::classMap());
        $this->assertContains(DataType::COLLECTION, DataType::classMap()[Collection::class]);
        $this->assertContains(DataType::DATE, DataType::classMap()[Carbon::class]);
        $this->assertContains(DataType::DATETIME, DataType::classMap()[Carbon::class]);
    }

    /**
     * @test
     * @covers ::aliases
     */
    public function it_returns_all_data_types_aliases(): void
    {
        $this->assertContains(DataType::INTEGER, DataType::INT->aliases());
        $this->assertContains(DataType::INT, DataType::INTEGER->aliases());
        $this->assertContains(DataType::BOOLEAN, DataType::BOOL->aliases());
        $this->assertContains(DataType::BOOL, DataType::BOOLEAN->aliases());
    }

    /**
     * @test
     * @covers ::convertValueToString
     */
    public function it_can_convert_a_data_type_to_a_string(): void
    {
        $this->assertEquals(
            '{"key":"value"}',
            DataType::ARRAY->convertValueToString(['key' => 'value'])
        );

        $this->assertEquals(
            '[1,2,3]',
            DataType::ARRAY->convertValueToString([1, 2, 3])
        );

        $this->assertEquals(
            '[{"key":"one","value":"oneone"},{"key":"two","value":"twotwo"}]',
            DataType::COLLECTION->convertValueToString(collect([
                ['key' => 'one', 'value' => 'oneone'],
                ['key' => 'two', 'value' => 'twotwo'],
            ]))
        );

        $this->assertEquals(
            '25',
            DataType::INT->convertValueToString(25)
        );

        $this->assertEquals(
            '2022-01-01 00:00:00',
            DataType::DATE->convertValueToString(Carbon::parse('Jan 1, 2022'))
        );
    }

    /**
     * @test
     * @covers ::primitiveMap
     */
    public function it_returns_map_data_types_to_their_primitive_version(): void
    {
        $this->assertIsArray(DataType::primitiveMap());

        foreach(DataType::primitives() as $primitive) {
            $this->assertArrayHasKey($primitive->value, DataType::primitiveMap());
        }
    }

    /**
     * @test
     * @covers ::isPrimitive
     */
    public function it_checks_if_given_data_type_is_primitive(): void
    {
        $this->assertTrue(DataType::OBJECT->isPrimitive());
        $this->assertTrue(DataType::ARRAY->isPrimitive());
        $this->assertTrue(DataType::STRING->isPrimitive());
        $this->assertTrue(DataType::INTEGER->isPrimitive());
        $this->assertTrue(DataType::BOOLEAN->isPrimitive());
        $this->assertTrue(DataType::DOUBLE->isPrimitive());
        $this->assertFalse(DataType::COLLECTION->isPrimitive());
        $this->assertFalse(DataType::DATE->isPrimitive());
        $this->assertFalse(DataType::JSON->isPrimitive());
    }

    /**
     * @test
     * @covers ::primitives
     */
    public function it_returns_an_array_of_primitive_data_types(): void
    {
        $primitives = [
            'array',
            'integer',
            'boolean',
            'double',
            'object',
            'string',
        ];

        $this->assertSameSize($primitives, DataType::primitives());
        foreach(DataType::primitives() as $type) {
            $this->assertTrue(in_array($type->value, $primitives));
            Arr::forget($primitives, array_search($type->value, $primitives));
        }
    }
}
