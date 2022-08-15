<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\database\seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;
use TaylorNetwork\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

class TestingSeeder extends Seeder
{
    public static array $modelMap = [
        'userUsingTrait' => UserUsingTrait::class,
        'userSettings' => Setting::class,
        'modelSettings' => Setting::class,
        'appSettings' => Setting::class,
        'globalSettings' => Setting::class,
    ];

    public static function userUsingTrait(): array
    {
        return [
            ['id' => 1, 'name' => 'Test User 1'],
            ['id' => 2, 'name' => 'Test User 2'],
            ['id' => 3, 'name' => 'Test User 3'],
        ];
    }

    public static function userSettings(): array
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

    public static function modelSettings(): array
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
                    'item' => 'key 1',
                    'value' => 'value 1',
                ]),
            ],
        ];
    }

    public static function appSettings(): array
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

    public static function globalSettings(): array
    {
        return [
            [
                'key' => 'global.test.array1',
                'setting_type' => SettingType::GLOBAL,
                'data_type' => DataType::ARRAY,
                'value' => ['one', 'two', 'three'],
            ],
            [
                'key' => 'global.test.assoc_array1',
                'setting_type' => SettingType::GLOBAL,
                'data_type' => DataType::ARRAY,
                'value' => [
                    'name' => 'item1',
                    'description' => 'the number one item'
                ],
            ],
            [
                'key' => 'global.test.multi_dimensional_array1',
                'setting_type' => SettingType::GLOBAL,
                'data_type' => DataType::ARRAY,
                'value' => [
                    'name' => 'item1',
                    'listing' => ['list1', 'list2', 'list3']
                ],
            ],
        ];
    }

    public static function totalSettingsSeeded(): int
    {
        return count(array_merge(static::userSettings(), static::modelSettings(), static::appSettings(), static::globalSettings()));
    }

    public function run()
    {
        foreach(static::$modelMap as $prop => $model) {
            foreach(static::$prop() as $item) {
                $model::create($item);
            }
        }
    }
}
