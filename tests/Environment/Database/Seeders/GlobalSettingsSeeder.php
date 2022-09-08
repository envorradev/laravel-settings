<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;


class GlobalSettingsSeeder extends SettingsSeeder
{

    public static function seed(): array
    {
        return [
            [
                'key' => 'global.test.array1',
                'setting_type' => 'global',
                'data_type' => 'array',
                'value' => ['one', 'two', 'three'],
            ],
            [
                'key' => 'global.test.assoc_array1',
                'setting_type' => 'global',
                'data_type' => 'array',
                'value' => [
                    'name' => 'item1',
                    'description' => 'the number one item',
                ],
            ],
            [
                'key' => 'global.test.multi_dimensional_array1',
                'setting_type' => 'global',
                'data_type' => 'array',
                'value' => [
                    'name' => 'item1',
                    'listing' => ['list1', 'list2', 'list3'],
                ],
            ],
        ];
    }
}
