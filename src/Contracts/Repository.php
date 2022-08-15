<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;

interface Repository
{
    public function findOrFail(string $key): Setting;

    public function find(string $key): ?Setting;

    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value, ?SettingType $settingType = null): Setting;

    public function where(string $field, mixed $operatorOrValue, mixed $valueOrNull = null): Builder;

    public function query(): Builder;

    public function all(): SettingsCollection;

    public function allOfType(SettingType $type): SettingsCollection;

    public function allOwnedBy(SettingOwner $owner, SettingType|array $filterTypes = []): SettingsCollection;

    public function allRelatedToModel(Model $model, SettingType|array $filterTypes = []): SettingsCollection;
}
