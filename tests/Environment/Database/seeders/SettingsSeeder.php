<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\Database\Seeders;

use TaylorNetwork\LaravelSettings\Models\Setting;

abstract class SettingsSeeder extends Seeder
{
    public static string $model = Setting::class;

    public static function groupSeedCount(): int
    {
        return AppSettingsSeeder::seedCount()
                + GlobalSettingsSeeder::seedCount()
                + ModelSettingsSeeder::seedCount()
                + UserSettingsSeeder::seedCount();
    }
}

