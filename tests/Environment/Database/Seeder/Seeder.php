<?php

namespace Envorra\LaravelSettings\Tests\Environment\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder as EloquentSeeder;

abstract class Seeder extends EloquentSeeder
{
    /**
     * @var class-string<Model>
     */
    public static string $model;

    abstract public static function seed(): array;

    public static function seedCount(): int
    {
        return count(static::seed());
    }

    /**
     * @return void
     */
    public function run(): void
    {
        foreach (static::seed() as $item) {
            /** @phpstan-ignore-next-line */
            static::$model::create($item);
        }
    }
}
