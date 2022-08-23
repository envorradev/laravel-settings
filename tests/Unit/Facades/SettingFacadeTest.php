<?php

namespace Envorra\LaravelSettings\Tests\Unit\Facades;

use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Facades\Setting;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Facades\Setting
 */
class SettingFacadeTest extends TestCase
{
    /**
     * @test
     * @noinspection PhpUndefinedClassInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function it_can_use_alias(): void
    {
        /** @phpstan-ignore-next-line */
        $this->assertInstanceOf(SettingsRepository::class, \SettingAlias::instance());
    }

    /** @test */
    public function it_can_use_facade(): void
    {
        $this->assertInstanceOf(SettingsRepository::class, Setting::instance());
    }
}
