<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;

use Illuminate\Support\Collection;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

class ModelSettingsSeeder extends SettingsSeeder
{

    public static function seed(): array
    {
        return [
            [
                'key' => 'model.test.string1',
                'setting_type' => 'model',
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 3,
                'data_type' => 'string',
                'value' => 'test string',
            ],
            [
                'key' => 'model.test.collection1',
                'setting_type' => 'model',
                'owner_type' => UserUsingTrait::class,
                'owner_id' => 3,
                'data_type' => 'collection',
                'value' => new Collection([
                    'someKey' => 'key 1',
                    'someValue' => 'value 1',
                ]),
            ],
        ];
    }
}
