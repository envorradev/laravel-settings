<?php

namespace TaylorNetwork\LaravelSettings\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Contracts\Repository;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;

class SettingsRepository implements Repository
{
    protected static string $model = Setting::class;

    protected static ?SettingType $settingType = null;

    public function findOrFail(string $key): Setting
    {
        return $this->normalizeCollection($this->where('key', $key)->take(1)->get())->firstOrFail();
    }

    public function find(string $key): ?Setting
    {
        return $this->normalizeCollection($this->where('key', $key)->take(1)->get())->first();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->find($key) ?? $default;
    }

    public function set(string $key, mixed $value, ?SettingType $settingType = null): Setting
    {
        // TODO: Implement set() method.
    }

    public function where(string $field, mixed $operatorOrValue, mixed $valueOrNull = null): Builder
    {
        return $this->query()->where($field, $operatorOrValue, $valueOrNull);
    }

    public function model(): Setting
    {
        return new (static::$model)();
    }

    public function query(): Builder
    {
        $query = $this->model()::query();

        if(static::$settingType) {
            $query->where('setting_type', static::$settingType);
        }

        return $query;
    }

    public function all(): SettingsCollection
    {
        return $this->normalizeCollection(($this->query())->get());
    }

    public function allOfType(SettingType $type): SettingsCollection
    {
        return $this->normalizeCollection($this->query()->where('setting_type', $type)->get());
    }

    public function allRelatedToModel(Model $model, array|SettingType $filterTypes = []): SettingsCollection
    {
        return $this->normalizeCollection(
                    $this->filterQuery(
                        query: $this->query()->whereMorphedTo('owner', $model),
                        filterTypes: $filterTypes
                    )->get()
        );
    }

    protected function filterQuery(Builder $query, array|SettingType $filterTypes = []): Builder
    {
        if(count($filterTypes)) {
            $query->where(function($subQuery) use ($filterTypes) {
                $wheres = 1;
                 foreach(Arr::wrap($filterTypes) as $type) {
                     $type = SettingType::make($type);
                     $whereMethod = $wheres === 1 ? 'where' : 'orWhere';
                     $subQuery->$whereMethod('setting_type', $type);
                     $wheres++;
                 }
            });
        }

        return $query;
    }

    public function normalizeCollection(iterable $iterable): SettingsCollection
    {
        return SettingsCollection::from($iterable);
    }

    public static function instance(): static
    {
        return new static();
    }

    public static function repositorySettingType(): ?SettingType
    {
        return static::$settingType;
    }
}
