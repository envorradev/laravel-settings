<?php

namespace Envorra\LaravelSettings\Tests\Unit\Enums;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Exceptions\DataTypeException;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Enums\DataType
 */
class DataTypeTest extends TestCase
{
    /**
     * @test
     * @covers ::convertValueToString
     */
    public function it_can_execute_convertValueToString_method(): void
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
     * @covers ::isIn
     */
    public function it_can_execute_isIn_method(): void
    {
        $this->checkEnumIsInMethod(DataType::class);
    }

    /**
     * @test
     * @covers ::isPrimitive
     */
    public function it_can_execute_isPrimitive_method(): void
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
     * @covers ::is
     */
    public function it_can_execute_is_method(): void
    {
        $this->checkEnumIsMethod(DataType::class);
    }

    /**
     * @test
     * @covers ::resolveObjectClass
     */
    public function it_can_execute_resolveObjectClass_method(): void
    {
        $this->assertEquals(Collection::class, DataType::COLLECTION->resolveObjectClass());
        $this->assertEquals(Carbon::class, DataType::DATE->resolveObjectClass());
        $this->assertEquals(Carbon::class, DataType::DATETIME->resolveObjectClass());
        $this->assertNull(DataType::TIMESTAMP->resolveObjectClass());
    }

    /**
     * @test
     * @covers ::aliasMap
     */
    public function it_can_execute_static_aliasMap_method(): void
    {
        $map = DataType::aliasMap();
        $this->assertIsArray($map);
        foreach ($map as $types) {
            $this->assertIsArray($types);
            $this->assertAllInstanceOf(DataType::class, $types);
        }
    }

    /**
     * @test
     * @covers ::aliases
     */
    public function it_can_execute_static_aliases_method(): void
    {
        $this->assertContains(DataType::INTEGER, DataType::INT->aliases());
        $this->assertContains(DataType::INT, DataType::INTEGER->aliases());
        $this->assertContains(DataType::BOOLEAN, DataType::BOOL->aliases());
        $this->assertContains(DataType::BOOL, DataType::BOOLEAN->aliases());
    }

    /**
     * @test
     * @covers ::areAllOfPrimitiveType
     * @throws DataTypeException
     */
    public function it_can_execute_static_areAllOfPrimitiveType_method(): void
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
     * @covers ::areAllOfType
     */
    public function it_can_execute_static_areAllOfType_method(): void
    {
        $this->assertTrue(DataType::areAllOfType(DataType::INT, [DataType::INTEGER, DataType::INT]));
        $this->assertTrue(DataType::areAllOfType(DataType::FLOAT, [DataType::DOUBLE, DataType::REAL]));
        $this->assertFalse(DataType::areAllOfType(DataType::OBJECT, [DataType::COLLECTION, DataType::DATE]));
    }

    /**
     * @test
     * @covers ::classMap
     */
    public function it_can_execute_static_classMap_method(): void
    {
        $this->assertIsArray(DataType::classMap());
        $this->assertContains(DataType::COLLECTION, DataType::classMap()[Collection::class]);
        $this->assertContains(DataType::DATE, DataType::classMap()[Carbon::class]);
        $this->assertContains(DataType::DATETIME, DataType::classMap()[Carbon::class]);
    }

    /**
     * @test
     * @covers ::fromValue
     */
    public function it_can_execute_static_fromValue_method(): void
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
     * @covers ::integerIsValidTimestamp
     */
    public function it_can_execute_static_integerIsValidTimestamp_method(): void
    {
        $this->assertTrue(DataType::integerIsValidTimestamp(time()));
        $this->assertFalse(DataType::integerIsValidTimestamp(999999999999));
    }

    /**
     * @test
     * @covers ::primitiveMap
     */
    public function it_can_execute_static_primitiveMap_method(): void
    {
        $this->assertIsArray(DataType::primitiveMap());

        foreach (DataType::primitives() as $primitive) {
            $this->assertArrayHasKey($primitive->value, DataType::primitiveMap());
        }
    }

    /**
     * @test
     * @covers ::primitives
     */
    public function it_can_execute_static_primitives_method(): void
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
        foreach (DataType::primitives() as $type) {
            $this->assertTrue(in_array($type->value, $primitives));
            Arr::forget($primitives, array_search($type->value, $primitives));
        }
    }

    /**
     * @test
     * @covers ::stringIsValidJson
     */
    public function it_can_execute_static_stringIsValidJson_method(): void
    {
        $this->assertTrue(DataType::stringIsValidJson('{}'));
        $this->assertTrue(DataType::stringIsValidJson('["array","of","values"]'));
        $this->assertFalse(DataType::stringIsValidJson('test'));
    }

    /**
     * @test
     * @covers ::values
     */
    public function it_can_execute_static_values_method(): void
    {
        $this->checkEnumValuesMethod(DataType::class);
    }

    /**
     * @test
     * @covers ::toPrimitive
     */
    public function it_can_execute_toPrimitive_method(): void
    {
        $this->assertEquals(DataType::INTEGER, DataType::TIMESTAMP->toPrimitive());
        $this->assertEquals(DataType::STRING, DataType::JSON->toPrimitive());
        $this->assertEquals(DataType::OBJECT, DataType::COLLECTION->toPrimitive());
        $this->assertEquals(DataType::OBJECT, DataType::DATETIME->toPrimitive());
        $this->assertEquals(DataType::INTEGER, DataType::INT->toPrimitive());
    }

    /**
     * @test
     * @covers ::valueIsType
     */
    public function it_can_execute_valueIsType_method(): void
    {
        $this->assertTrue(DataType::INT->valueIsType(25));
        $this->assertTrue(DataType::STRING->valueIsType('test'));
        $this->assertTrue(DataType::JSON->valueIsType('{"key":"value"}'));
        $this->assertTrue(DataType::COLLECTION->valueIsType(collect()));
        $this->assertFalse(DataType::INTEGER->valueIsType('25'));
    }
}
