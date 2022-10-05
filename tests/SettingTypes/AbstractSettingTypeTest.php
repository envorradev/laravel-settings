<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\SettingTypes;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\SettingTypes\AppSettingType;
use Envorra\LaravelSettings\SettingTypes\AbstractSettingType;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\SettingTypes\AbstractSettingType
 */
class AbstractSettingTypeTest extends TestCase
{
    /**
     * @test
     * @covers ::apply
     */
    public function it_can_apply_scope_to_query(): void
    {
        $model = new class extends Model {
            protected $fillable = [
                'key',
                'setting_type',
                'value',
            ];
        };

        $builder = $model::query();

        $this->assertNotEquals(
            $builder,
            $this->app()->apply($model::query(), $model)
        );

        $this->assertEquals(
            $builder->where('setting_type', 'app'),
            $this->app()->apply($model::query(), $model)
        );
    }

    /**
     * @test
     * @covers ::__toString
     */
    public function it_can_be_cast_to_string(): void
    {
        $this->assertEquals('app', (string) $this->app());
    }

    /**
     * @test
     * @covers ::toString
     */
    public function it_can_be_converted_to_string(): void
    {
        $this->assertEquals('app', $this->app()->toString());
    }

    /**
     * @test
     * @covers ::settingTypeColumn
     */
    public function it_can_get_setting_type_column(): void
    {
        $this->assertEquals('setting_type', $this->app()->settingTypeColumn());
    }

    /**
     * @test
     * @covers ::name
     */
    public function it_can_get_type_name(): void
    {
        $this->assertEquals('app', $this->app()->name());
    }

    protected function app(): AbstractSettingType
    {
        return new AppSettingType();
    }
}
