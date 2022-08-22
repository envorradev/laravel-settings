<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;

use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Enums\SettingType;

class GlobalSettingsSeeder extends SettingsSeeder
{

    public static function seed(): array
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
}
