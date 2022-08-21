<?php

namespace TaylorNetwork\LaravelSettings\Tests\Unit;

use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Facades\Setting;
use TaylorNetwork\LaravelSettings\Repositories\AppSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\GlobalSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\ModelSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\UserSettingsRepository;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class FacadeTest extends TestCase
{
    /** @test */
    public function it_can_resolve_repository(): void
    {
        $this->assertInstanceOf(SettingsRepository::class, Setting::instance());
    }

    /** @test */
    public function it_can_resolve_global_repository(): void
    {
        $this->assertInstanceOf(GlobalSettingsRepository::class, Setting::global());
    }

    /** @test */
    public function it_can_resolve_app_repository(): void
    {
        $this->assertInstanceOf(AppSettingsRepository::class, Setting::app());
    }

    /** @test */
    public function it_can_resolve_model_repository(): void
    {
        $this->assertInstanceOf(ModelSettingsRepository::class, Setting::model());
    }

    /** @test */
    public function it_can_resolve_user_repository(): void
    {
        $this->assertInstanceOf(UserSettingsRepository::class, Setting::user());
    }

    /** @test */
    public function it_can_resolve_using_scope_method(): void
    {
        $this->assertInstanceOf(UserSettingsRepository::class, Setting::scope('user'));
    }

    /** @test */
    public function it_can_get_without_specifying_scope(): void
    {
        $setting = Setting::get('app.test.float1');
        $this->assertIsDataType(DataType::FLOAT, $setting);
        $this->assertEquals(7.5, $setting);
    }

    /** @test */
    public function it_can_get_with_specifying_scope(): void
    {
        $setting = Setting::global()->get('global.test.array1');
        $this->assertIsDataType(DataType::ARRAY, $setting);
        $this->assertEquals(['one', 'two', 'three'], $setting);
    }

    /** @test */
    public function it_cannot_get_from_different_scope(): void
    {
        $this->assertNull(Setting::global()->get('app.test.float1'));
    }
}
