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

    /**
     * @test
     * @covers ::getDataType
     */
    public function it_can_get_dataType(): void
    {
        $this->assertEquals(
            DataType::COLLECTION,
            Setting::where('data_type', DataType::COLLECTION)->first()->getDataType()
        );
    }

    /**
     * @test
     * @covers ::getDataType
     */
    public function it_can_get_default_dataType(): void
    {
        $this->assertEquals(DataType::STRING, $this->emptyModel()->getDataType());
    }

    /**
     * @test
     * @covers ::modelFromArray
     */
    public function it_can_make_model_from_array_with_correct_structure(): void
    {
        $this->assertModelExists(Setting::modelFromArray($this->modelArray()));
    }

    /**
     * @test
     * @covers ::modelFromJson
     */
    public function it_can_make_model_from_valid_json(): void
    {
        $this->assertModelExists(Setting::modelFromJson(json_encode($this->modelArray())));

    }

    /**
     * @test
     * @covers \Envorra\LaravelSettings\Traits\HasOwner::setOwner
     */
    public function it_can_set_owner_on_new_model(): void
    {
        $owner = UserUsingTrait::find(1);
        $setting = new Setting();
        $this->assertInstanceOf(Setting::class, $setting->setOwner($owner));
        $this->assertEquals($owner, $setting->owner);
    }

    /**
     * @test
     * @covers ::modelFromArray
     */
    public function it_cannot_make_model_from_array_with_incorrect_structure(): void
    {
        $this->assertNull(Setting::modelFromArray([$this->modelArray()]));
    }

    /**
     * @test
     * @covers ::modelFromJson
     */
    public function it_cannot_make_model_from_invalid_json(): void
    {
        $this->assertNull(Setting::modelFromJson('not json'));
    }

    /**
     * @test
     * @covers ::modelFromJson
     */
    public function it_cannot_make_model_from_valid_json_without_model_structure(): void
    {
        $this->assertNull(Setting::modelFromJson('['.json_encode($this->modelArray()).']'));
    }

    /**
     * @test
     * @covers \Envorra\LaravelSettings\Traits\HasOwner::setOwner
     */
    public function it_cannot_set_owner_on_existing_model(): void
    {
        $owner = UserUsingTrait::find(1);
        $setting = Setting::first();
        $setting->setOwner($owner);
        $this->assertNotEquals($owner, $setting->owner);
    }

    protected function emptyModel(): Setting
    {
        return new Setting;
    }

    protected function modelArray(): array
    {
        return [
            'key' => 'app.test.float1',
            'setting_type' => SettingType::APP,
            'data_type' => DataType::FLOAT,
            'value' => 7.5,
        ];
    }
}
