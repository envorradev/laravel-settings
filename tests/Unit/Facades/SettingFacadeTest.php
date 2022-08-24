<?php

namespace Envorra\LaravelSettings\Tests\Unit\Facades;

use ReflectionException;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Facades\Setting;
use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Facades\Setting
 */
class SettingFacadeTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_get_without_specifying_instance(): void
    {
        $this->assertModelExists(Setting::all()->first());
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function it_can_specify_scope(): void
    {
        $repository = Setting::user();

        $this->assertEquals(
            SettingType::USER,
            $this->reflect($repository)->getProperty('scopeSettingType')->getValue($repository)
        );
    }

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
