<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Traits;

use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Resolvers\SettingTypeResolver;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Traits\AliasesSnakeCaseAttributes
 */
class AliasesSnakeCaseAttributesTest extends TestCase
{
    /**
     * @test
     * @covers ::setAttribute
     */
    public function it_can_execute_set_snake_attributes(): void
    {
        $setting = $this->newSetting();

        $this->assertNull($setting->setting_type);

        $setting->setting_type = SettingTypeResolver::resolve('app');

        $this->assertEquals('app', $setting->setting_type);
    }

    /**
     * @test
     * @covers ::getAttribute
     */
    public function it_can_get_camel_attributes(): void
    {
        $this->assertEquals('app', $this->newSetting(['setting_type' => 'app'])->settingType);
    }

    /**
     * @test
     * @covers ::getAttribute
     */
    public function it_can_get_snake_attributes(): void
    {

        $this->assertEquals('app', $this->newSetting(['setting_type' => 'app'])->setting_type);
    }

    /**
     * @test
     * @covers ::setAttribute
     */
    public function it_can_set_camel_attributes(): void
    {
        $setting = $this->newSetting();

        $this->assertNull($setting->settingType);

        $setting->settingType = SettingTypeResolver::resolve('app');

        $this->assertEquals('app', $setting->settingType);
    }

    protected function newSetting(array $attributes = []): Setting
    {
        return Setting::unguarded(fn() => new Setting($attributes));
    }
}
