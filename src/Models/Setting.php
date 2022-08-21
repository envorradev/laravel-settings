<?php

namespace TaylorNetwork\LaravelSettings\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Traits\HasOwner;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Contracts\ModelOwnership;
use TaylorNetwork\LaravelSettings\Casters\DynamicTypeCaster;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Contracts\DynamicallyCastsTypes;
use TaylorNetwork\LaravelSettings\Traits\AliasesSnakeCaseAttributes;


/**
 * Setting
 *
 * @package TaylorNetwork\LaravelSettings
 *
 * @property ?SettingType $settingType
 * @property ?SettingType $setting_type
 * @property ?DataType    $dataType
 * @property ?DataType    $data_type
 * @property mixed        $owner
 * @property mixed        $value
 *
 * @method static static firstOrCreate(array $attributes = [], array $values = [])
 * @see     Builder
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
     * @return static
     */
    public static function modelFromArray(array $attributes): static
    {
        return static::firstOrCreate($attributes);
    }

    /**
     * Get a new model instance from JSON.
     *
     * @param  string  $json
     * @return ?static
     */
    public static function modelFromJson(string $json): ?static
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
