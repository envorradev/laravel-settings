<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Casters;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\TypeHandler\Contracts\Types\Type;
use Envorra\LaravelSettings\Casters\ValueCaster;
use Envorra\LaravelSettings\Contracts\HasDataType;
use Envorra\TypeHandler\Types\Primitives\IntegerType;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Casters\ValueCaster
 */
class ValueCasterTest extends TestCase
{
    /**
     * @test
     * @covers ::set
     */
    public function it_can_cast_from_mixed_to_string_model_has_data_type(): void
    {
        $this->assertSame(
            '5',
            $this->caster()->set($this->modelWithDataType(), 'value', 5, [])
        );
    }

    /**
     * @test
     * @covers ::set
     */
    public function it_can_cast_from_mixed_to_string_using_value_only(): void
    {
        $this->assertSame(
            '5.5',
            $this->caster()->set($this->model(), 'value', 5.5, [])
        );
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_cast_from_string_to_given_data_type_with_has_data_type(): void
    {
        $this->assertSame(
            5,
            $this->caster()->get($this->modelWithDataType(), 'value', '5', [])
        );
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_cast_from_string_to_given_data_type_without_has_data_type(): void
    {
        $this->assertSame(
            '5',
            $this->caster()->get($this->model(), 'value', '5', [])
        );
    }

    /**
     * @test
     * @covers ::set
     */
    public function it_can_cast_from_string_to_string(): void
    {
        $this->assertSame(
            'string',
            $this->caster()->set($this->model(), 'value', 'string', [])
        );
    }

    /**
     * @test
     * @covers ::set
     */
    public function it_can_cast_from_stringable_to_string(): void
    {
        $this->assertSame(
            '5',
            $this->caster()->set($this->model(), 'value', IntegerType::make(5), [])
        );
    }

    protected function caster(): ValueCaster
    {
        return new ValueCaster();
    }

    protected function model(): Model
    {
        return new class extends Model {
        };
    }

    protected function modelWithDataType(): Model
    {
        return new class extends Model implements HasDataType {
            /**
             * @inheritDoc
             */
            public function getDataType(): Type
            {
                return IntegerType::make();
            }
        };
    }
}
