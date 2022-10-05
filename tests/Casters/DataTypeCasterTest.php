<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Casters;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Casters\DataTypeCaster;
use Envorra\TypeHandler\Types\Primitives\IntegerType;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Casters\DataTypeCaster
 */
class DataTypeCasterTest extends TestCase
{
    /**
     * @test
     * @covers ::set
     */
    public function it_can_cast_from_data_type(): void
    {
        $this->assertSame(
            'integer',
            $this->caster()->set($this->model(), 'data_type', IntegerType::make(), [])
        );
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_cast_to_data_type(): void
    {
        $this->assertEquals(
            IntegerType::make(),
            $this->caster()->get($this->model(), 'data_type', 'integer', [])
        );
    }

    protected function caster(): DataTypeCaster
    {
        return new DataTypeCaster();
    }

    protected function model(): Model
    {
        return new class extends Model {
        };
    }
}
