<?php

namespace TaylorNetwork\LaravelSettings\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Repositories\AppSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\GlobalSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\ModelSettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;
use TaylorNetwork\LaravelSettings\Repositories\UserSettingsRepository;
use TaylorNetwork\LaravelSettings\Models\Setting as SettingModel;
/**
 * @method SettingModel findOrFail(string $key)
 * @method SettingModel|null find(string $key)
 * @method mixed get(string $key, mixed $default = null)
 * @method SettingModel set(string $key, mixed $value, ?SettingType $settingType = null)
 * @method Builder where(string $field, mixed $operatorOrValue, mixed $valueOrNull = null)
 * @method SettingModel getModel()
 * @method Builder query()
 * @method SettingsCollection all()
 * @method SettingsCollection allOfType(SettingType $settingType)
 * @method SettingsCollection allRelatedToModel(Model $model, array|SettingType $filterTypes = [])
 * @method SettingsCollection normalizeCollection(iterable $iterable)
 * @method static SettingsRepository instance()
 * @method static SettingType|null repositorySettingType()
 * @method static SettingsRepository scope(string $scope)
 * @method static GlobalSettingsRepository global()
 * @method static AppSettingsRepository app()
 * @method static ModelSettingsRepository model()
 * @method static UserSettingsRepository user()
 * @see SettingsRepository
 */
class Setting extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Setting';
    }
}
