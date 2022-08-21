<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\Database\Seeders;

use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;

class AppSettingsSeeder extends SettingsSeeder
{

    public static function seed(): array
    {
        return [
            [
                'key' => 'app.test.float1',
                'setting_type' => SettingType::APP,
                'data_type' => DataType::FLOAT,
                'value' => 7.5,
            ],
        ];
    }
}
