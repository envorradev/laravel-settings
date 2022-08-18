<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ItemNotFoundException;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;

/**
 * Contract Repository
 *
 * @package TaylorNetwork\LaravelSettings
 */
interface Repository
{
    /**
     * Repository Constructor.
     *
     * @param ?SettingType $scopeSettingType
     * @param ?Model $scopeOwner
     * @param ?DataType $scopeDataType
     * @param ?Builder $query
     */
    public function __construct(
        ?SettingType $scopeSettingType = null,
        ?Model $scopeOwner = null,
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    );

    /**
     * Find a Setting, or fail.
     *
     * @param string $key
     * @return Setting
     * @throws ItemNotFoundException
     */
    public function findOrFail(string $key): Setting;

    /**
     * Find a Setting.
     *
     * @param string $key
     * @return ?Setting
     */
    public function find(string $key): ?Setting;

    /**
     * Get a Setting's value or the default.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Set a setting.
     *
     * @param string $key
     * @param mixed $value
     * @param ?string $description
     * @param ?SettingType $settingType
     * @param ?DataType $dataType
     * @param ?SettingOwner $owner
     * @return Setting
     */
    public function set(
        string $key,
        mixed $value,
        ?string $description,
        ?SettingType $settingType = null,
        ?DataType $dataType = null,
        ?SettingOwner $owner = null,
    ): Setting;

    /**
     * Where query.
     *
     * @param string $field
     * @param mixed $operatorOrValue
     * @param mixed $valueOrNull
     * @return Builder
     */
    public function where(string $field, mixed $operatorOrValue, mixed $valueOrNull = null): Builder;

    /**
     * Where the owner is.
     *
     * @param Model $owner
     * @return Builder
     */
    public function whereOwner(Model $owner): Builder;

    /**
     * Get the current query.
     *
     * @return Builder
     */
    public function query(): Builder;

    /**
     * New query.
     *
     * @return Builder
     */
    public function newQuery(): Builder;

    /**
     * Get all the Settings.
     *
     * @return SettingsCollection
     */
    public function all(): SettingsCollection;

    /**
     * Get all Settings of a SettingType.
     *
     * @param SettingType $type
     * @return SettingsCollection
     */
    public function allOfType(SettingType $type): SettingsCollection;

    /**
     * Get all Settings related to a Model.
     *
     * @param Model $model
     * @param SettingType|array<SettingType> $filterTypes
     * @return SettingsCollection
     */
    public function allRelatedToModel(Model $model, SettingType|array $filterTypes = []): SettingsCollection;

    /**
     * Normalize the Collection to a SettingsCollection.
     *
     * @template TKey of array-key
     * @param iterable<TKey, Setting|array> $iterable
     * @return SettingsCollection
     */
    public function normalizeCollection(iterable $iterable): SettingsCollection;

    /**
     * New repository instance.
     *
     * @param ?SettingType $scopeSettingType
     * @param ?Model $scopeOwner
     * @param ?DataType $scopeDataType
     * @param ?Builder $query
     * @return static
     */
    public static function instance(
        ?SettingType $scopeSettingType = null,
        ?Model $scopeOwner = null,
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): static;

    /**
     * Get global scoped repository.
     *
     * @param ?DataType $scopeDataType
     * @param ?Builder $query
     * @return Repository
     */
    public static function global(
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): Repository;

    /**
     * Get app scoped repository.
     *
     * @param ?DataType $scopeDataType
     * @param ?Builder $query
     * @return Repository
     */
    public static function app(
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): Repository;

    /**
     * Get model scoped repository.
     *
     * @param Model $scopeOwner
     * @param ?DataType $scopeDataType
     * @param ?Builder $query
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
     * @param ?DataType $scopeDataType
     * @param ?Builder $query
     * @return Repository
     */
    public static function user(
        ?DataType $scopeDataType = null,
        ?Builder $query = null,
    ): Repository;
}
