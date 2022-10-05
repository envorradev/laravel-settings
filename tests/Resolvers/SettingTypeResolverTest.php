<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Resolvers;

use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Resolvers\SettingTypeResolver;
use Envorra\LaravelSettings\SettingTypes\GlobalSettingType;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Resolvers\SettingTypeResolver
 */
class SettingTypeResolverTest extends TestCase
{

    /**
     * @test
     * @covers ::resolve
     */
    public function it_can_resolve_setting_types_from_alias(): void
    {
        $this->assertInstanceOf(GlobalSettingType::class, SettingTypeResolver::resolve('global'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function it_can_resolve_setting_types_from_basename(): void
    {
        $this->assertInstanceOf(GlobalSettingType::class, SettingTypeResolver::resolve('GlobalSettingType'));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function it_can_resolve_setting_types_from_class(): void
    {
        $this->assertInstanceOf(GlobalSettingType::class, SettingTypeResolver::resolve(GlobalSettingType::class));
    }

    /**
     * @test
     * @covers ::resolve
     */
    public function it_returns_null_on_failure(): void
    {
        $this->assertNull(SettingTypeResolver::resolve('does-not-exist'));
    }
}
