<?php

namespace TaylorNetwork\LaravelSettings\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Contracts\Repository;
use TaylorNetwork\LaravelSettings\Contracts\SettingOwner;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;

abstract class SettingsRepository implements Repository
{
    protected static SettingType $repositorySettingType;

    protected SettingsCollection $collection;

    public function __construct()
    {
        $this->collection = new SettingsCollection();
    }

    public function findOrFail(string $key): Setting
    {
        // TODO: Implement findOrFail() method.
    }

    public function find(string $key): ?Setting
    {
        // TODO: Implement find() method.
    }

    public function get(string $key, mixed $default = null): mixed
    {
        // TODO: Implement get() method.
    }

    public function set(string $key, mixed $value, ?SettingType $settingType = null): Setting
    {
        // TODO: Implement set() method.
    }

    public function where(string $field, mixed $operatorOrValue, mixed $valueOrNull = null): Builder
    {
        // TODO: Implement where() method.
    }

    public function queryBuilder(): Builder
    {
        // TODO: Implement queryBuilder() method.
    }

    public function all(): SettingsCollection
    {
        // TODO: Implement all() method.
    }

    public function allOfType(SettingType $type): SettingsCollection
    {
        // TODO: Implement allOfType() method.
    }

    public function allOwnedBy(SettingOwner $owner, array|SettingType $filterTypes = []): SettingsCollection
    {
        // TODO: Implement allOwnedBy() method.
    }

    public function allRelatedToModel(Model $model, array|SettingType $filterTypes = []): SettingsCollection
    {
        // TODO: Implement allRelatedToModel() method.
    }

}
