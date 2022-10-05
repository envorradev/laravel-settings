<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Helpers;

use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Helpers\ConfigHelper;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Helpers\ConfigHelper
 */
class ConfigHelperTest extends TestCase
{
    /**
     * @test
     * @covers ::column
     */
    public function it_can_get_column_from_map(): void
    {
        $this->assertEquals('value', ConfigHelper::column('value'));
    }

    /**
     * @test
     * @covers ::map
     */
    public function it_can_get_column_map(): void
    {
        $this->assertEquals([], ConfigHelper::map());
    }

    /**
     * @test
     * @covers ::dataTypeColumn
     */
    public function it_can_get_data_type_column(): void
    {
        $this->assertEquals('data_type', ConfigHelper::dataTypeColumn());
    }

    /**
     * @test
     * @covers ::descriptionColumn
     */
    public function it_can_get_description_column(): void
    {
        $this->assertEquals('description', ConfigHelper::descriptionColumn());
    }

    /**
     * @test
     * @covers ::get
     */
    public function it_can_get_from_config(): void
    {
        $this->assertEquals([], ConfigHelper::get('setting_type_directories'));
        $this->assertNull(ConfigHelper::get('does_not_exist'));
    }

    /**
     * @test
     * @covers ::idColumn
     */
    public function it_can_get_id_column(): void
    {
        $this->assertEquals('id', ConfigHelper::idColumn());
    }

    /**
     * @test
     * @covers ::keyColumn
     */
    public function it_can_get_key_column(): void
    {
        $this->assertEquals('key', ConfigHelper::keyColumn());
    }

    /**
     * @test
     * @covers ::ownerRelation
     */
    public function it_can_get_morph_owner_relation_name(): void
    {
        $this->assertEquals('owner', ConfigHelper::ownerRelation());
    }

    /**
     * @test
     * @covers ::settingTypeColumn
     */
    public function it_can_get_setting_type_column(): void
    {
        $this->assertEquals('setting_type', ConfigHelper::settingTypeColumn());
    }

    /**
     * @test
     * @covers ::model
     */
    public function it_can_get_settings_model_class(): void
    {
        $this->assertEquals(Setting::class, ConfigHelper::model());
    }

    /**
     * @test
     * @covers ::valueColumn
     */
    public function it_can_get_value_column(): void
    {
        $this->assertEquals('value', ConfigHelper::valueColumn());
    }

    /**
     * @test
     * @covers ::__callStatic
     */
    public function it_returns_null_on_callStatic_failure(): void
    {
        /** @phpstan-ignore-next-line */
        $this->assertNull(ConfigHelper::someMethodDoesNotExist());
    }
}
