<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\RepositoryTests;

use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;
use TaylorNetwork\LaravelSettings\Tests\Environment\database\seeders\TestingSeeder;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class SettingsRepositoryTest extends TestCase
{
    protected function repository(): SettingsRepository
    {
        return new SettingsRepository();
    }

    /** @test */
    public function it_can_get_all_settings(): void
    {
        $settings = $this->repository()->all();
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertCount(TestingSeeder::totalSettingsSeeded(), $settings);
    }

    /** @test */
    public function it_can_filter_by_single_setting_type(): void
    {
        $settings = $this->repository()->allOfType(SettingType::APP);
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertSameSize(TestingSeeder::$appSettings, $settings);
    }

    /** @test */
    public function it_can_find_a_setting(): void
    {
        $setting = $this->repository()->find('user.test.int1');
        $this->assertInstanceOf(Setting::class, $setting);
        $this->assertTrue($setting->data_type->valueIsType($setting->value));
        $this->assertEquals(4, $setting->value);
    }
}
