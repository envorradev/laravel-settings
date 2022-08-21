<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\Database\Seeders;

use Illuminate\Support\Collection;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

class ModelSettingsSeeder extends SettingsSeeder
{

    public static function seed(): array
    {
        return [
            [
                'key' => 'model.test.string1',
                'setting_type' => SettingType::MODEL,
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 3,
                'data_type' => DataType::STRING,
                'value' => 'test string',
            ],
            [
                'key' => 'model.test.collection1',
                'setting_type' => SettingType::MODEL,
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 3,
                'data_type' => DataType::COLLECTION,
                'value' => new Collection([
                    'someKey' => 'key 1',
                    'someValue' => 'value 1',
                ]),
            ],
        ];
    }
}
