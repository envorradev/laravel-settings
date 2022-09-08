<?php

namespace Envorra\LaravelSettings\Models;

use Envorra\TypeHandler\Contracts\Types\Type;
use Envorra\LaravelSettings\Casters\ValueCaster;
use Envorra\LaravelSettings\Contracts\SettingType;
use Envorra\LaravelSettings\Casters\DataTypeCaster;
use Envorra\LaravelSettings\Casters\SettingTypeCaster;
use Envorra\LaravelSettings\Traits\AliasesSnakeCaseAttributes;


/**
 * Setting
 *
 * @package Envorra\LaravelSettings\Models
 *
 * @property int          $id
 * @property ?Type        $dataType
 * @property ?Type        $data_type
 * @property ?SettingType $settingType
 * @property ?SettingType $setting_type
 * @property mixed        $owner
 * @property mixed        $value
 */
class Setting extends AbstractSettingModel
{
    use AliasesSnakeCaseAttributes;

    /**
     * @inheritDoc
     */
    protected $casts = [
        'data_type' => DataTypeCaster::class,
        'setting_type' => SettingTypeCaster::class,
        'value' => ValueCaster::class,
    ];

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'key',
        'description',
        'data_type',
        'value',
    ];
}
