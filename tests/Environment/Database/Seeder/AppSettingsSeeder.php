<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeder;

use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Enums\SettingType;

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
