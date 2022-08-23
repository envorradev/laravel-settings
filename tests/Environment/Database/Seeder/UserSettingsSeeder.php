<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeder;

use Carbon\Carbon;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

class UserSettingsSeeder extends SettingsSeeder
{
    public static function seed(): array
    {
        return [
            [
                'key' => 'user.test.int1',
                'setting_type' => SettingType::USER,
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 1,
                'data_type' => DataType::INT,
                'value' => 4,
            ],
            [
                'key' => 'user.test.int2',
                'setting_type' => SettingType::USER,
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => DataType::INT,
                'value' => 7,
            ],
            [
                'key' => 'user.test.date1',
                'setting_type' => SettingType::USER,
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => DataType::DATE,
                'value' => Carbon::today(),
            ],
            [
                'key' => 'user.test.datetime1',
                'setting_type' => SettingType::USER,
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => DataType::DATETIME,
                'value' => Carbon::now(),
            ],
            [
                'key' => 'user.test.timestamp1',
                'setting_type' => SettingType::USER,
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => DataType::TIMESTAMP,
                'value' => time(),
            ],
        ];
    }
}
