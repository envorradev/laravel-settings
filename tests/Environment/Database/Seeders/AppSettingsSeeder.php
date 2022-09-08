<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;


use Envorra\LaravelSettings\SettingTypes\AppSettingType;

class AppSettingsSeeder extends SettingsSeeder
{

    public static function seed(): array
    {
        return [
            [
                'key' => 'app.test.float1',
                'setting_type' => 'app',
                'data_type' => 'double',
                'value' => 7.5,
            ],
        ];
    }
}
