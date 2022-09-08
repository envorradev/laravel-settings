<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;

use Carbon\Carbon;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

class UserSettingsSeeder extends SettingsSeeder
{
    public static function seed(): array
    {
        return [
            [
                'key' => 'user.test.int1',
                'setting_type' => 'user',
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 1,
                'data_type' => 'integer',
                'value' => 4,
            ],
            [
                'key' => 'user.test.int2',
                'setting_type' => 'user',
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => 'integer',
                'value' => 7,
            ],
            [
                'key' => 'user.test.date1',
                'setting_type' => 'user',
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => 'date',
                'value' => Carbon::today(),
            ],
            [
                'key' => 'user.test.datetime1',
                'setting_type' => 'user',
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => 'datetime',
                'value' => Carbon::now(),
            ],
            [
                'key' => 'user.test.timestamp1',
                'setting_type' => 'user',
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 2,
                'data_type' => 'timestamp',
                'value' => time(),
            ],
        ];
    }
}
