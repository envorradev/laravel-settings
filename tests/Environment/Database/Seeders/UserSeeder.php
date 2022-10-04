<?php declare(strict_types=1);

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * UserSeeder
 *
 * @package Envorra\LaravelSettings\Tests\Environment\Database\Seeders
 */
class UserSeeder extends Seeder
{
    public const USERS = [
        ['name' => 'User 1'],
        ['name' => 'User 2'],
        ['name' => 'User 3'],
        ['name' => 'User 4'],
    ];

    public static function count(): int
    {
        return count(self::USERS);
    }

    public function run(): void
    {
        foreach (self::USERS as $user) {
            DB::table('users')->insert($user);
        }
    }
}
