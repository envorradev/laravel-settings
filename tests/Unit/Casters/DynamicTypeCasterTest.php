<?php

namespace Envorra\LaravelSettings\Tests\Unit\Casters;

use ReflectionException;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Casters\DynamicTypeCaster;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Casters\DynamicTypeCaster
 */
class DynamicTypeCasterTest extends TestCase
{
    /**
     * @test
     * @covers ::getCastedAttribute
     */
    public function it_can_execute_getCastedAttribute_method(): void
    {
        $this->assertEquals($this->modelValueAsType(), $this->casterStringToType()->getCastedAttribute());
    }

    /**
     * @test
     * @covers ::__call
     */
    public function it_can_execute_get_method(): void
    {
        $this->assertEquals(
            expected: $this->modelValueAsType(),
            actual: $this->casterEmpty()->get(...$this->casterArgsStringToType())
        );
    }

    /**
     * @test
     * @covers ::newInstance
     */
    public function it_can_execute_newInstance_method(): void
    {
        $this->assertNotEquals($this->casterStringToType(), $this->casterEmpty());

        $this->assertEquals(
            expected: $this->casterStringToType(),
            actual: $this->casterEmpty()->newInstance(...$this->casterArgsStringToType())
        );
    }

    /**
     * @test
     * @covers ::setCastedAttribute
     */
    public function it_can_execute_setCastedAttribute_method(): void
    {
        $this->assertEquals($this->modelValueAsString(), $this->casterTypeToString()->setCastedAttribute());
    }

    /**
     * @test
     * @covers ::setDataType
     * @throws ReflectionException
     */
    public function it_can_execute_setDataType_method(): void
    {
        $caster = $this->casterEmpty();

        $this->assertNull($this->reflectPropValue('dataType', $caster));
        $this->assertInstanceOf(DynamicTypeCaster::class, $caster->setDataType(DataType::COLLECTION));
        $this->assertEquals(DataType::COLLECTION, $this->reflectPropValue('dataType', $caster));
    }

    /**
     * @test
     * @covers ::setKey
     * @throws ReflectionException
     */
    public function it_can_execute_setKey_method(): void
    {
        $caster = $this->casterEmpty();

        $this->assertNull($this->reflectPropValue('key', $caster));
        $this->assertInstanceOf(DynamicTypeCaster::class, $caster->setKey('value'));
        $this->assertEquals('value', $this->reflectPropValue('key', $caster));
    }

    /**
     * @test
     * @covers ::setModelAttributes
     * @throws ReflectionException
     */
    public function it_can_execute_setModelAttributes_method(): void
    {
        $caster = $this->casterEmpty();

        $this->assertEmpty($this->reflectPropValue('modelAttributes', $caster));
        $this->assertInstanceOf(DynamicTypeCaster::class, $caster->setModelAttributes(['value' => 'some value']));
        $this->assertEquals(['value' => 'some value'], $this->reflectPropValue('modelAttributes', $caster));
    }

    /**
     * @test
     * @covers ::setModel
     * @throws ReflectionException
     */
    public function it_can_execute_setModel_method(): void
    {
        $caster = $this->casterEmpty();
        $model = new Setting(['value' => 'value 1']);

        $this->assertNull($this->reflectPropValue('model', $caster));
        $this->assertInstanceOf(DynamicTypeCaster::class, $caster->setModel($model));
        $this->assertEquals($model, $this->reflectPropValue('model', $caster));
    }

    /**
     * @test
     * @covers ::setValue
     * @throws ReflectionException
     */
    public function it_can_execute_setValue_method(): void
    {
        $caster = $this->casterEmpty();

        $this->assertNull($this->reflectPropValue('value', $caster));
        $this->assertInstanceOf(DynamicTypeCaster::class, $caster->setValue('some value'));
        $this->assertEquals('some value', $this->reflectPropValue('value', $caster));
    }

    /**
     * @test
     * @covers ::__call
     */
    public function it_can_execute_set_method(): void
    {
        $this->assertEquals(
            expected: $this->modelValueAsString(),
            actual: $this->casterEmpty()->set(...$this->casterArgsTypeToString())
        );
    }

    /**
     * @test
     * @covers ::updateCasts
     * @throws ReflectionException
     */
    public function it_can_execute_updateCasts_method(): void
    {
        $caster = $this->casterEmpty();

        $this->assertEquals([], $this->reflectPropValue('casts', $caster));
        $this->assertInstanceOf(DynamicTypeCaster::class, $caster->updateCasts('value', DataType::INT));
        $this->assertEquals(['value' => DataType::INT->value], $this->reflectPropValue('casts', $caster));
    }

    /**
     * @test
     * @covers ::__call
     */
    public function it_can_forward_calls_to_model(): void
    {
        $this->assertFalse(method_exists($this->casterStringToType(), 'query'));
        $this->assertInstanceOf(Builder::class, $this->casterStringToType()->query());
    }

    /**
     * @test
     * @covers ::__construct
     */
    public function it_can_make_new_instance(): void
    {
        $this->assertInstanceOf(DynamicTypeCaster::class, $this->casterEmpty());
    }

    /**
     * @test
     * @covers ::validateInstance
     */
    public function it_can_validate_a_valid_instance(): void
    {
        $this->assertTrue($this->casterStringToType()->validateInstance());
    }

    /**
     * @test
     * @covers ::validateInstance
     */
    public function it_can_validate_an_invalid_instance(): void
    {
        $this->assertFalse($this->casterEmpty()->validateInstance());
    }

    protected function casterArgsStringToType(): array
    {
        return [
            'model' => $this->model(),
            'key' => 'value',
            'value' => $this->modelValueAsString(),
            'modelAttributes' => [
                'key' => 'some-key',
                'value' => $this->modelValueAsString(),
                'data_type' => DataType::ARRAY,
            ],
        ];
    }

    protected function casterArgsTypeToString(): array
    {
        return [
            'model' => $this->model(),
            'key' => 'value',
            'value' => $this->modelValueAsType(),
            'modelAttributes' => [
                'key' => 'some-key',
                'value' => $this->modelValueAsType(),
                'data_type' => DataType::ARRAY,
            ],
        ];
    }

    protected function casterEmpty(): DynamicTypeCaster
    {
        return new DynamicTypeCaster();
    }

    protected function casterStringToType(): DynamicTypeCaster
    {
        return new DynamicTypeCaster(...$this->casterArgsStringToType());
    }

    protected function casterTypeToString(): DynamicTypeCaster
    {
        return new DynamicTypeCaster(...$this->casterArgsTypeToString());
    }

    protected function defaultClassToReflect(): string|object|null
    {
        return DynamicTypeCaster::class;
    }

    protected function model(): Setting
    {
        return new Setting([
            'key' => 'some-key',
            'value' => $this->modelValueAsString(),
            'data_type' => DataType::ARRAY,
        ]);
    }

    protected function modelValueAsString(): string
    {
        return '["one","two","three"]';
    }

    protected function modelValueAsType(): mixed
    {
        return json_decode($this->modelValueAsString(), true);
    }
}
