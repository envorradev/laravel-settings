<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package;

use Illuminate\Support\Collection;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class HelperTest extends TestCase
{
    /** @test */
    public function helper_is_loaded(): void
    {
        $this->assertTrue(function_exists('setting'));
    }

    /** @test */
    public function it_can_get_setting_without_scope(): void
    {
        $setting = setting(key: 'model.test.collection1');
        $this->assertInstanceOf(Collection::class, $setting);
        $this->assertEquals('key 1', $setting['someKey']);
        $this->assertEquals('value 1', $setting['someValue']);
    }

    /** @test */
    public function it_can_get_setting_with_scope(): void
    {
        $setting = setting(key: 'global.test.assoc_array1', scope: 'global');
        $this->assertIsArray($setting);
        $this->assertEquals('item1', $setting['name']);
    }

    /** @test */
    public function it_cannot_get_setting_out_of_scope(): void
    {
        $setting = setting(key: 'global.test.assoc_array1', scope: 'app');
        $this->assertNull($setting);
    }

    /** @test */
    public function it_returns_default_if_not_found(): void
    {
        $setting = setting(key: 'some.unknown.key', default: 'default value');
        $this->assertEquals('default value', $setting);
    }

    /** @test */
    public function it_returns_default_if_not_found_in_scope(): void
    {
        $setting = setting(key: 'global.test.array1', default: 'default value', scope: 'app');
        $this->assertEquals('default value', $setting);
    }

    /** @test */
    public function it_returns_default_type_of_collection(): void
    {
        $setting = setting(key: 'some.unknown.key', default: collect(['new', 'collection']));
        $this->assertInstanceOf(Collection::class, $setting);
        $this->assertEquals(['new', 'collection'], $setting->toArray());
    }
}
