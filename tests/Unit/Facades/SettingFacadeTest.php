<?php

namespace TaylorNetwork\LaravelSettings\Tests\Unit\Facades;

use TaylorNetwork\LaravelSettings\Facades\Setting;
use TaylorNetwork\LaravelSettings\Tests\TestCase;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;

/**
 * @coversDefaultClass \TaylorNetwork\LaravelSettings\Facades\Setting
 */
class SettingFacadeTest extends TestCase
{
    /** @test */
    public function it_can_use_facade(): void
    {
        $this->assertInstanceOf(SettingsRepository::class, Setting::instance());
    }

    /** @test */
    public function it_can_use_alias(): void
    {
        /** @phpstan-ignore-next-line */
        $this->assertInstanceOf(SettingsRepository::class, \SettingAlias::instance());
    }
}
