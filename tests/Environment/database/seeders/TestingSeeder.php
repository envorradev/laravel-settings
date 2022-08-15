<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\database\seeders;

use Illuminate\Database\Seeder;
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

    public static array $userUsingTrait = [
        ['id' => 1, 'name' => 'Test User 1'],
        ['id' => 2, 'name' => 'Test User 2'],
        ['id' => 3, 'name' => 'Test User 3'],
    ];

    public static array $userSettings = [
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
    ];

    public static array $modelSettings = [
        [
            'key' => 'model.test.string1',
            'setting_type' => SettingType::MODEL,
            'owner_type' => UserUsingTrait::class,
            'owner_id' => 3,
            'data_type' => DataType::STRING,
            'value' => 'test string',
        ],
    ];

    public static array $appSettings = [
        [
            'key' => 'app.test.float1',
            'setting_type' => SettingType::APP,
            'data_type' => DataType::FLOAT,
            'value' => 7.5,
        ],
    ];

    public static array $globalSettings = [
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

    public static function totalSettingsSeeded(): int
    {
        return count(array_merge(static::$userSettings, static::$modelSettings, static::$appSettings, static::$globalSettings));
    }

    public function run()
    {
        foreach(static::$modelMap as $prop => $model) {
            foreach(static::$$prop as $item) {
                $model::create($item);
            }
        }
    }
}
