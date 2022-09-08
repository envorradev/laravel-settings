<?php

namespace Envorra\LaravelSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Envorra\TypeHandler\Contracts\Types\Type;
use Envorra\LaravelSettings\Helpers\ConfigHelper;
use Envorra\LaravelSettings\Contracts\HasDataType;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Envorra\TypeHandler\Types\Primitives\StringType;
use Envorra\LaravelSettings\Contracts\ModelFromJson;
use Envorra\LaravelSettings\Contracts\ModelFromArray;

/**
 * AbstractSettingModel
 *
 * @package Envorra\LaravelSettings\Models
 *
 * @mixin Builder
 */
abstract class AbstractSettingModel extends Model implements HasDataType, ModelFromJson, ModelFromArray
{
    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public static function modelFromJson(string $json): ?Model
    {
        $arrayModel = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || is_int(array_key_first($arrayModel))) {
            return null;
        }

        return static::modelFromArray($arrayModel);
    }

    /**
     * @inheritDoc
     */
    public function getDataType(): Type
    {
        $dataTypeColumn = ConfigHelper::dataTypeColumn();
        return $this->$dataTypeColumn ?? StringType::make();
    }

    /**
     * @return MorphTo
     */
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
