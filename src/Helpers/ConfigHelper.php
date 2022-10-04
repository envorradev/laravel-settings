<?php

namespace Envorra\LaravelSettings\Helpers;

use Illuminate\Support\Str;
use Envorra\LaravelSettings\Models\Setting;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * ColumnHelper
 *
 * @package Envorra\LaravelSettings\Helpers
 *
 * @method static string idColumn()
 * @method static string keyColumn()
 * @method static string dataTypeColumn()
 * @method static string settingTypeColumn()
 * @method static string valueColumn()
 * @method static string descriptionColumn()
 */
class ConfigHelper
{
    private function __construct()
    {

    }

    /**
     * @param  string  $name
     * @param  array   $arguments
     * @return string|null
     */
    public static function __callStatic(string $name, array $arguments): ?string
    {
        if (str_ends_with($name, 'Column')) {
            return static::column(str_replace('Column', '', $name));
        }
        return null;
    }

    /**
     * @param  string  $name
     * @return string
     */
    public static function column(string $name): string
    {
        $name = Str::snake($name);
        return static::map()[$name] ?? static::map()[Str::camel($name)] ?? $name;
    }

    /**
     * @param  string      $key
     * @param  mixed|null  $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            return config('laravel_settings.'.$key, $default);
        } catch (BindingResolutionException) {
            return $default;
        }
    }

    /**
     * @return array<string, string>
     */
    public static function map(): array
    {
        return static::get('column_map', []);
    }

    /**
     * @return string
     */
    public static function model(): string
    {
        return static::get('setting_model', Setting::class);
    }

    /**
     * @return string
     */
    public static function ownerRelation(): string
    {
        return static::get('morph_to_relation_name', 'owner');
    }
}
