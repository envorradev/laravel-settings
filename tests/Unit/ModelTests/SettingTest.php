<?php

namespace TaylorNetwork\LaravelSettings\Tests\Unit\ModelTests;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;
use TaylorNetwork\LaravelSettings\Tests\Environment\database\seeders\TestingSeeder;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class SettingTest extends TestCase
{
    /** @test */
    public function it_can_all_settings(): void
    {
        $settings = Setting::all();
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertCount(TestingSeeder::totalSettingsSeeded(), $settings);
    }

    /** @test */
    public function it_can_get_settings_by_settingType(): void
    {
        $settings = Setting::where('setting_type', SettingType::GLOBAL)->get();
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertSameSize(TestingSeeder::globalSettings(), $settings);
    }

    /** @test */
    public function it_correctly_casts_to_and_from_collection(): void
    {
        $setting = Setting::where('data_type', DataType::COLLECTION)->first();
        $this->assertModelExists($setting);
        $this->assertInstanceOf(Setting::class, $setting);
        $this->assertInstanceOf(Collection::class, $setting->value);
        $this->assertIsDataType(DataType::COLLECTION, $setting->value);
    }

    /** @test */
    public function it_correctly_casts_to_and_from_date(): void
    {
        $setting = Setting::where('data_type', DataType::DATE)->first();
        $this->assertModelExists($setting);
        $this->assertInstanceOf(Setting::class, $setting);
        $this->assertInstanceOf(Carbon::class, $setting->value);
        $this->assertIsDataType(DataType::DATE, $setting->value);
    }

    /** @test */
    public function it_correctly_casts_to_and_from_datetime(): void
    {
        $setting = Setting::where('data_type', DataType::DATETIME)->first();
        $this->assertModelExists($setting);
        $this->assertInstanceOf(Setting::class, $setting);
        $this->assertInstanceOf(Carbon::class, $setting->value);
        $this->assertIsDataType(DataType::DATETIME, $setting->value);
    }

    /** @test */
    public function it_correctly_casts_to_and_from_timestamp(): void
    {
        $setting = Setting::where('data_type', DataType::TIMESTAMP)->first();
        $this->assertModelExists($setting);
        $this->assertInstanceOf(Setting::class, $setting);
        $this->assertIsInt($setting->value);
        $this->assertIsDataType(DataType::TIMESTAMP, $setting->value);
    }
}
