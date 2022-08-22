<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeders;

use Envorra\LaravelSettings\Tests\Environment\Models\UserUsingTrait;

class UserUsingTraitSeeder extends Seeder
{
    public static string $model = UserUsingTrait::class;

    public static function seed(): array
    {
        return [
            ['name' => 'User 1'],
            ['name' => 'User 2'],
            ['name' => 'User 3'],
            ['name' => 'User 4'],
        ];
    }
}
