<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\RepositoryTests;

use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Repositories\AppSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\GlobalSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\ModelSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\UserSettingsRepository;
use TaylorNetwork\LaravelSettings\Tests\Environment\database\seeders\TestingSeeder;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class TypedSettingsRepositoryTest extends TestCase
{

    protected function assertRepositoryGetsScopedSettings(SettingsRepository $repository): void
    {
        $settings = $repository->all();
        $seederTypeString = $repository::repositorySettingType()?->value.'Settings';

        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertSameSize(TestingSeeder::$seederTypeString(), $settings);
        $this->assertAllOfSettingType($repository::repositorySettingType(), $settings);
    }

    /** @test */
    public function test_global_settings_repository(): void
    {
        $this->assertRepositoryGetsScopedSettings(GlobalSettingsRepository::instance());
    }

    /** @test */
    public function test_app_settings_repository(): void
    {
        $this->assertRepositoryGetsScopedSettings(AppSettingsRepository::instance());
    }

    /** @test */
    public function test_model_settings_repository(): void
    {
        $this->assertRepositoryGetsScopedSettings(ModelSettingsRepository::instance());
    }

    /** @test */
    public function test_user_settings_repository(): void
    {
        $this->assertRepositoryGetsScopedSettings(UserSettingsRepository::instance());
    }

    /** @test */
    public function it_cannot_get_settings_out_of_scope(): void
    {
        $settings = GlobalSettingsRepository::instance()->allOfType(SettingType::USER);
        $this->assertInstanceOf(SettingsCollection::class, $settings);
        $this->assertCount(0, $settings);
    }
}
