<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

/**
 * SettingSeeder
 *
 * @package Envorra\LaravelSettings\Tests\Environment\Database\Seeders
 */
class SettingSeeder extends Seeder
{
    public const GLOBAL_SETTINGS = [
        [
            'key' => 'global.test.array1',
            'setting_type' => 'global',
            'data_type' => 'array',
            'value' => '["one","two","three"]',
        ],
        [
            'key' => 'global.test.assoc_array1',
            'setting_type' => 'global',
            'data_type' => 'array',
            'value' => '{"name":"item1","description":"the number one item"}',
        ],
        [
            'key' => 'global.test.multi_dimensional_array1',
            'setting_type' => 'global',
            'data_type' => 'array',
            'value' => '{"name":"item1","listing":["list1","list2","list3"]}',
        ],
    ];

    public const APP_SETTINGS = [
        [
            'key' => 'app.test.float1',
            'setting_type' => 'app',
            'data_type' => 'double',
            'value' => '7.5',
        ],
    ];

    public const MODEL_SETTINGS = [
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
            'value' => '{"someKey":"key 1","someValue":"value 1"}',
        ],
    ];

    public const USER_SETTINGS = [
        [
            'key' => 'user.test.int1',
            'setting_type' => 'user',
            'owner_type' => UserUsingTrait::class,
            'owner_id' => 1,
            'data_type' => 'integer',
            'value' => '4',
        ],
        [
            'key' => 'user.test.int2',
            'setting_type' => 'user',
            'owner_type' => UserUsingTrait::class,
            'owner_id' => 2,
            'data_type' => 'integer',
            'value' => '7',
        ],
        [
            'key' => 'user.test.date1',
            'setting_type' => 'user',
            'owner_type' => UserUsingTrait::class,
            'owner_id' => 2,
            'data_type' => 'date',
            'value' => '2022-10-04 00:00:00',
        ],
        [
            'key' => 'user.test.datetime1',
            'setting_type' => 'user',
            'owner_type' => UserUsingTrait::class,
            'owner_id' => 2,
            'data_type' => 'datetime',
            'value' => '2022-10-04 15:05:02',
        ],
        [
            'key' => 'user.test.timestamp1',
            'setting_type' => 'user',
            'owner_type' => UserUsingTrait::class,
            'owner_id' => 2,
            'data_type' => 'timestamp',
            'value' => '1664895880',
        ],
    ];

    public static function count(): int
    {
        return count(self::settings());
    }

    public static function settings(): array
    {
        return array_merge(self::GLOBAL_SETTINGS, self::APP_SETTINGS, self::MODEL_SETTINGS, self::USER_SETTINGS);
    }

    public function run(): void
    {
        foreach (self::settings() as $setting) {
            DB::table('settings')->insert($setting);
        }
    }
}
