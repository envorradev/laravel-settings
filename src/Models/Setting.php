<?php

namespace TaylorNetwork\LaravelSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use TaylorNetwork\LaravelSettings\Casters\DynamicTypeCaster;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Contracts\DynamicallyCastsTypes;
use TaylorNetwork\LaravelSettings\Contracts\ModelOwnership;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Traits\AliasesSnakeCaseAttributes;
use TaylorNetwork\LaravelSettings\Traits\HasOwner;

/**
 * @property SettingType setting_type
 * @property DataType data_type
 */
class Setting extends Model implements ModelOwnership, DynamicallyCastsTypes
{
    use HasOwner;
    use AliasesSnakeCaseAttributes;

    protected $fillable = [
        'key',
        'description',
        'data_type',
        'value',
    ];

    protected $casts = [
        'data_type' => DataType::class,
        'setting_type' => SettingType::class,
        'value' => DynamicTypeCaster::class,
    ];


    public function getDataType(): DataType
    {
        return $this->data_type ?? DataType::STRING;
    }

    public function isGlobalSetting(): bool
    {
        return $this->isSettingType(SettingType::GLOBAL);
    }

    public function isAppSetting(): bool
    {
        return $this->isSettingType(SettingType::APP);
    }

    public function isUserSetting(): bool
    {
        return $this->isSettingType(SettingType::USER);
    }

    public function isModelSetting(): bool
    {
        return $this->isSettingType([
            SettingType::MODEL,
            SettingType::USER,
        ]);
    }

    public function isSettingType(SettingType|string|array $type): bool
    {
        return $this->setting_type?->isIn(Arr::wrap($type)) ?? false;
    }

    public function hasOwner(): bool
    {
        return $this->isModelSetting() && $this->owner;
    }

    public function newCollection(array $models = []): SettingsCollection
    {
        return new SettingsCollection($models);
    }
}
