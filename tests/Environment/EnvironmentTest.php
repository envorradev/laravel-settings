<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Environment;

use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\UserSeeder;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\SettingSeeder;

/**
 * EnvironmentTest
 *
 * @package Envorra\LaravelSettings\Tests\Environment
 */
class EnvironmentTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_seeded_the_records(): void
    {
        $this->assertDatabaseCount('settings', SettingSeeder::count());
        $this->assertDatabaseCount('users', UserSeeder::count());
    }

    /**
     * @test
     */
    public function it_has_working_assertions(): void
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
    }
}
