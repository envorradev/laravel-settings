<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\ModelTests;

use Illuminate\Support\Collection;
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
        $this->assertInstanceOf(Collection::class, $settings);
        $this->assertCount(TestingSeeder::totalSettingsSeeded(), $settings);
    }

    /** @test */
    public function it_can_get_settings_by_settingType(): void
    {
        $settings = Setting::where('setting_type', SettingType::GLOBAL)->get();
        $this->assertInstanceOf(Collection::class, $settings);
        $this->assertSameSize(TestingSeeder::$globalSettings, $settings);
    }
}
