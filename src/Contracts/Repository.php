<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ItemNotFoundException;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;

interface Repository
{
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
     * @param ?SettingType $settingType
     * @return Setting
     */
    public function set(string $key, mixed $value, ?SettingType $settingType = null): Setting;

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
     * New query.
     *
     * @return Builder
     */
    public function query(): Builder;

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
     * @param SettingType|array $filterTypes
     * @return SettingsCollection
     */
    public function allRelatedToModel(Model $model, SettingType|array $filterTypes = []): SettingsCollection;

    /**
     * Normalize the Collection to a SettingsCollection.
     *
     * @param iterable $iterable
     * @return SettingsCollection
     */
    public function normalizeCollection(iterable $iterable): SettingsCollection;

    /**
     * New repository instance.
     *
     * @return static
     */
    public static function instance(): static;

    /**
     * Get this repository's Setting Type.
     *
     * @return ?SettingType
     */
    public static function repositorySettingType(): ?SettingType;
}
