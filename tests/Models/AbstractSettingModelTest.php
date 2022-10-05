<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Models;

use Envorra\LaravelSettings\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Envorra\TypeHandler\Types\Primitives\StringType;
use Envorra\LaravelSettings\Models\AbstractSettingModel;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Models\AbstractSettingModel
 */
class AbstractSettingModelTest extends TestCase
{
    /**
     * @test
     * @covers ::getDataType
     */
    public function it_can_get_data_type(): void
    {
        $this->assertEquals(StringType::make(), $this->model()->getDataType());
    }

    /**
     * @test
     * @covers ::owner
     */
    public function it_can_get_model_owner_relation(): void
    {
        $this->assertInstanceOf(MorphTo::class, $this->model()->owner());
    }

    /**
     * @test
     * @covers ::modelFromArray
     */
    public function it_can_make_model_from_array(): void
    {
        $model = $this->model()::modelFromArray(['key' => 'some.key']);

        $this->assertModelExists($model);
        $this->assertEquals('some.key', $model->getAttribute('key'));
        $this->assertIsInt($model->getAttribute('id'));
        $this->assertNotNull($model->getAttribute('created_at'));
        $this->assertNotNull($model->getAttribute('updated_at'));
    }

    /**
     * @test
     * @covers ::modelFromJson
     */
    public function it_can_make_model_from_json(): void
    {
        $model = $this->model()::modelFromJson('{"key":"json.key"}');

        $this->assertModelExists($model);
        $this->assertEquals('json.key', $model->getAttribute('key'));
        $this->assertIsInt($model->getAttribute('id'));
        $this->assertNotNull($model->getAttribute('created_at'));
        $this->assertNotNull($model->getAttribute('updated_at'));
    }

    /**
     * @test
     * @covers ::modelFromJson
     */
    public function it_returns_null_when_json_is_invalid()
    {
        $this->assertNull($this->model()::modelFromJson('{"key":"some.value"'));
    }

    protected function model(array $attributes = []): AbstractSettingModel
    {
        return new class ($attributes) extends AbstractSettingModel {
            protected $table = 'settings';
            protected $fillable = ['key'];
        };
    }
}
