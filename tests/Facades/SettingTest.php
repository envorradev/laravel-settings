<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Facades;

use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Facades\Setting;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Facades\Setting
 */
class SettingTest extends TestCase
{
    /**
     * @test
     */
    public function it_aliases_settings_repository(): void
    {
        /** @phpstan-ignore-next-line */
        $this->assertInstanceOf(SettingsRepository::class, Setting::app());
    }
}
