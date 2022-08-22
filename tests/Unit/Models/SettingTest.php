<?php

namespace Envorra\LaravelSettings\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Enums\SettingType;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Envorra\LaravelSettings\Collections\SettingsCollection;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Models\Setting
 */
class SettingTest extends TestCase
{
    protected function emptyModel(): Setting
    {
        return new Setting;
    }

    /**
     * @test
     * @covers ::getDataType
     */
    public function it_can_execute_getDataType_method(): void
    {
        // Default data type
        $this->assertEquals(DataType::STRING, $this->emptyModel()->getDataType());

        $this->assertEquals(
            DataType::COLLECTION,
            Setting::where('data_type', DataType::COLLECTION)->first()->getDataType()
        );
    }

    /**
     * @test
     * @covers ::hasOwner
     */
    public function it_can_execute_hasOwner_method(): void
    {
        $this->assertFalse($this->emptyModel()->hasOwner());
        $this->assertFalse(Setting::where('setting_type', SettingType::GLOBAL)->first()->hasOwner());
        $this->assertTrue(Setting::where('setting_type', SettingType::MODEL)->first()->hasOwner());
    }

    /**
     * @test
     * @covers ::isAppSetting
     */
    public function it_can_execute_isAppSetting_method(): void
    {
        $this->assertFalse($this->emptyModel()->isAppSetting());
        $this->assertFalse(Setting::where('setting_type', SettingType::GLOBAL)->first()->isAppSetting());
        $this->assertTrue(Setting::where('setting_type', SettingType::APP)->first()->isAppSetting());
    }

    /**
     * @test
     * @covers ::isGlobalSetting
     */
    public function it_can_execute_isGlobalSetting_method(): void
    {
        $this->assertFalse($this->emptyModel()->isGlobalSetting());
        $this->assertFalse(Setting::where('setting_type', SettingType::APP)->first()->isGlobalSetting());
        $this->assertTrue(Setting::where('setting_type', SettingType::GLOBAL)->first()->isGlobalSetting());
    }

    /**
     * @test
     * @covers ::isModelSetting
     */
    public function it_can_execute_isModelSetting_method(): void
    {
        $this->assertFalse($this->emptyModel()->isModelSetting());
        $this->assertFalse(Setting::where('setting_type', SettingType::GLOBAL)->first()->isModelSetting());
        $this->assertTrue(Setting::where('setting_type', SettingType::MODEL)->first()->isModelSetting());
    }

    /**
     * @test
     * @covers ::isSettingType
     */
    public function it_can_execute_isSettingType_method(): void
    {
        $type = SettingType::APP;

        $this->assertFalse($this->emptyModel()->isSettingType($type));
        $this->assertFalse(Setting::where('setting_type', SettingType::GLOBAL)->first()->isSettingType($type));
        $this->assertTrue(Setting::where('setting_type', SettingType::APP)->first()->isSettingType($type));
    }

    /**
     * @test
     * @covers ::isUserSetting
     */
    public function it_can_execute_isUserSetting_method(): void
    {
        $this->assertFalse($this->emptyModel()->isUserSetting());
        $this->assertFalse(Setting::where('setting_type', SettingType::GLOBAL)->first()->isUserSetting());
        $this->assertTrue(Setting::where('setting_type', SettingType::USER)->first()->isUserSetting());
    }

    /**
     * @test
     * @covers ::modelFromArray
     */
    public function it_can_execute_static_modelFromArray_method(): void
    {
        $array = [
            'key' => 'app.test.float1',
            'setting_type' => SettingType::APP,
            'data_type' => DataType::FLOAT,
            'value' => 7.5,
        ];

        $this->assertModelExists(Setting::modelFromArray($array));
        $this->assertNull(Setting::modelFromArray([$array]));
    }

    /**
     * @test
     * @covers ::modelFromJson
     */
    public function it_can_execute_static_modelFromJson_method(): void
    {
        $json = '{"key":"app.test.float1","setting_type":"app","data_type":"float","value":"7.5"}';

        $this->assertModelExists(Setting::modelFromJson($json));
        $this->assertNull(Setting::modelFromJson('['.$json.']'));
    }

    /**
     * @test
     * @covers ::newCollection
     */
    public function it_can_execute_newCollection_method(): void
    {
        $this->assertInstanceOf(SettingsCollection::class, $this->emptyModel()->newCollection());
    }

    /**
     * @test
     * @covers \Envorra\LaravelSettings\Traits\HasOwner::owner
     */
    public function it_can_execute_owner_method(): void
    {
        $model = Setting::where('setting_type', SettingType::MODEL)->first();

        $this->assertInstanceOf(MorphTo::class, $model->owner());
        $this->assertInstanceOf(Model::class, $model->owner);
    }

    /**
     * @test
     * @covers \Envorra\LaravelSettings\Traits\HasOwner::belongsToModel
     */
    public function it_can_execute_belongsToModel_method(): void
    {
        $setting = Setting::where('setting_type', SettingType::MODEL)->first();

        $this->assertFalse($setting->belongsToModel(UserUsingTrait::find(1)));
        $this->assertTrue($setting->belongsToModel(UserUsingTrait::find(3)));
    }

    /**
     * @test
     * @covers \Envorra\LaravelSettings\Traits\AliasesSnakeCaseAttributes::getAttribute
     */
    public function it_can_execute_getAttribute_method(): void
    {
        $setting = Setting::where('key', 'global.test.array1')->first();

        $this->assertIsSettingType(SettingType::GLOBAL, $setting->setting_type);
        $this->assertIsSettingType(SettingType::GLOBAL, $setting->settingType);
        $this->assertIsSettingType(SettingType::GLOBAL, $setting->getAttribute('setting_type'));
        $this->assertIsSettingType(SettingType::GLOBAL, $setting->getAttribute('settingType'));
    }

    /**
     * @test
     * @covers \Envorra\LaravelSettings\Traits\AliasesSnakeCaseAttributes::setAttribute
     */
    public function it_can_execute_setAttribute_method(): void
    {
        $setting = new Setting();

        $this->assertNull($setting->data_type);
        $this->assertNull($setting->setting_type);

        $setting->setAttribute('data_type', DataType::ARRAY);
        $setting->setAttribute('settingType', SettingType::APP);

        $this->assertEquals(DataType::ARRAY, $setting->data_type);
        $this->assertEquals(SettingType::APP, $setting->setting_type);

    }
}
