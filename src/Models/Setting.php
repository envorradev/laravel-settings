<?php

namespace Envorra\LaravelSettings\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Traits\HasOwner;
use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Contracts\ModelOwnership;
use Envorra\LaravelSettings\Casters\DynamicTypeCaster;
use Envorra\LaravelSettings\Collections\SettingsCollection;
use Envorra\LaravelSettings\Contracts\DynamicallyCastsTypes;
use Envorra\LaravelSettings\Traits\AliasesSnakeCaseAttributes;


/**
 * Setting
 *
 * @package Envorra\LaravelSettings
 *
 * @property int $id
 * @property ?SettingType $settingType
 * @property ?SettingType $setting_type
 * @property ?DataType    $dataType
 * @property ?DataType    $data_type
 * @property mixed        $owner
 * @property mixed        $value
 *
 * @mixin Builder
 */
class Setting extends Model implements ModelOwnership, DynamicallyCastsTypes
{
    use HasOwner;
    use AliasesSnakeCaseAttributes;

    /**
     * @inheritDoc
     */
    protected $casts = [
        'data_type' => DataType::class,
        'setting_type' => SettingType::class,
        'value' => DynamicTypeCaster::class,
    ];
    /**
     * @inheritDoc
     */
    protected $fillable = [
        'key',
        'description',
        'data_type',
        'value',
    ];

    /**
     * Get a new model instance from an array.
     *
     * @param  array  $attributes
     * @return ?Model
     */
    public static function modelFromArray(array $attributes): ?Model
    {
        try {
            return static::firstOrCreate($attributes);
        } catch (QueryException) {
            return null;
        }
    }

    /**
     * Get a new model instance from JSON.
     *
     * @param  string  $json
     * @return ?Model
     */
    public static function modelFromJson(string $json): ?Model
    {
        $arrayModel = json_decode($json, true);

        if (is_int(array_key_first($arrayModel))) {
            return null;
        }

        return static::modelFromArray($arrayModel);
    }

    /**
     * @inheritDoc
     */
    public function getDataType(): DataType
    {
        return $this->dataType ?? DataType::STRING;
    }

    /**
     * Does this Model have an owner?
     *
     * @return bool
     */
    public function hasOwner(): bool
    {
        return $this->isModelSetting() && $this->owner;
    }

    /**
     * Is this an App setting?
     *
     * @return bool
     */
    public function isAppSetting(): bool
    {
        return $this->isSettingType(SettingType::APP);
    }

    /**
     * Is this a Global setting?
     *
     * @return bool
     */
    public function isGlobalSetting(): bool
    {
        return $this->isSettingType(SettingType::GLOBAL);
    }

    /**
     * Is this a Model setting?
     *
     * @return bool
     */
    public function isModelSetting(): bool
    {
        return $this->isSettingType([
            SettingType::MODEL,
            SettingType::USER,
        ]);
    }

    /**
     * Check if this is the same SettingType as given.
     *
     * @param  SettingType|string|array  $type
     * @return bool
     */
    public function isSettingType(SettingType|string|array $type): bool
    {
        return $this->settingType?->isIn(Arr::wrap($type)) ?? false;
    }

    /**
     * Is this a User setting?
     *
     * @return bool
     */
    public function isUserSetting(): bool
    {
        return $this->isSettingType(SettingType::USER);
    }

    /**
     * @inheritDoc
     */
    public function newCollection(array $models = []): SettingsCollection
    {
        return new SettingsCollection($models);
    }
}
