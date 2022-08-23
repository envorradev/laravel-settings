<?php

namespace Envorra\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Models\Setting;
use Illuminate\Support\ItemNotFoundException;
use Envorra\LaravelSettings\Enums\SettingType;
use Illuminate\Contracts\Auth\Authenticatable;
use Envorra\LaravelSettings\Collections\SettingsCollection;

/**
 * Repository
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface Repository
{
    /**
     * Repository Constructor.
     *
     * @param ?SettingType                 $scopeSettingType
     * @param  Model|Authenticatable|null  $scopeOwner
     * @param ?DataType                    $scopeDataType
     * @param ?Builder                     $query
     */
    public function __construct(
        ?SettingType $scopeSettingType = null,
        Model|Authenticatable|null $scopeOwner = null,
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    );

    /**
     * Get app scoped repository.
     *
     * @param ?DataType  $scopeDataType
     * @param ?Builder   $query
     * @return Repository
     */
    public static function app(
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): Repository;

    /**
     * Get global scoped repository.
     *
     * @param ?DataType  $scopeDataType
     * @param ?Builder   $query
     * @return Repository
     */
    public static function global(
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): Repository;

    /**
     * New repository instance.
     *
     * @param ?SettingType                 $scopeSettingType
     * @param  Model|Authenticatable|null  $scopeOwner
     * @param ?DataType                    $scopeDataType
     * @param ?Builder                     $query
     * @return static
     */
    public static function instance(
        ?SettingType $scopeSettingType = null,
        Model|Authenticatable|null $scopeOwner = null,
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): static;

    /**
     * Get model scoped repository.
     *
     * @param  Model     $scopeOwner
     * @param ?DataType  $scopeDataType
     * @param ?Builder   $query
     * @return Repository
     */
    public static function model(
        Model $scopeOwner,
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): Repository;

    /**
     * Get user scoped repository.
     *
     * @param  Model|Authenticatable|null  $scopeUser
     * @param ?DataType                    $scopeDataType
     * @param ?Builder                     $query
     * @return Repository
     */
    public static function user(
        Model|Authenticatable|null $scopeUser = null,
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): Repository;

    /**
     * Get all the Settings.
     *
     * @return SettingsCollection
     */
    public function all(): SettingsCollection;

    /**
     * Get all Settings of a SettingType.
     *
     * @param  DataType  $dataType
     * @return SettingsCollection
     */
    public function allOfDataType(DataType $dataType): SettingsCollection;

    /**
     * Get all Settings of a SettingType.
     *
     * @param  SettingType  $settingType
     * @return SettingsCollection
     */
    public function allOfSettingType(SettingType $settingType): SettingsCollection;

    /**
     * Get all Settings related to a Model.
     *
     * @param  Model                           $model
     * @param  SettingType|array<SettingType>  $filterTypes
     * @return SettingsCollection
     */
    public function allRelatedToModel(Model $model, SettingType|array $filterTypes = []): SettingsCollection;

    /**
     * Find a Setting.
     *
     * @param  string  $key
     * @return ?Setting
     */
    public function find(string $key): ?Setting;

    /**
     * Find a Setting, or fail.
     *
     * @param  string  $key
     * @return Setting
     * @throws ItemNotFoundException
     */
    public function findOrFail(string $key): Setting;

    /**
     * Get a Setting's value or the default.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * New query.
     *
     * @return Builder
     */
    public function newQuery(): Builder;

    /**
     * Get the current query.
     *
     * @return Builder
     */
    public function query(): Builder;

    /**
     * Set a setting.
     *
     * @param  string       $key
     * @param  mixed        $value
     * @param ?string       $description
     * @param ?SettingType  $settingType
     * @param ?DataType     $dataType
     * @param ?Model        $owner
     * @return ?Setting
     */
    public function set(
        string $key,
        mixed $value,
        ?string $description = null,
        ?SettingType $settingType = null,
        ?DataType $dataType = null,
        ?Model $owner = null,
    ): ?Setting;

    /**
     * Where query.
     *
     * @param  string  $field
     * @param  mixed   $operatorOrValue
     * @param  mixed   $valueOrNull
     * @return Builder
     */
    public function where(string $field, mixed $operatorOrValue, mixed $valueOrNull = null): Builder;

    /**
     * Where the owner is.
     *
     * @param  Model  $owner
     * @return Builder
     */
    public function whereOwner(Model $owner): Builder;
}
